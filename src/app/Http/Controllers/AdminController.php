<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use App\Models\Grade;
use OwenIt\Auditing\Models\Audit; // Asegúrate de importar esto si usas auditoría
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 📌 Asignar un alumno a un grupo
    public function addStudentToGroup(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id',
        ]);

        $student = User::find($request->student_id);
        $group = Group::find($request->group_id);

        // Asocia el grupo al alumno
        $student->group()->associate($group);
        $student->save();

        return redirect()->back()->with('success', 'Alumno agregado al grupo exitosamente');
    }

    // 🗑️ Quitar a un alumno del grupo
    public function removeStudentFromGroup(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::find($request->student_id);

        // Elimina la relación con el grupo
        $student->group()->dissociate();
        $student->save();

        return redirect()->back()->with('success', 'Alumno eliminado del grupo exitosamente');
    }

    // 👨‍🏫 Crear un docente o tutor
    public function createTeacherOrTutor(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:docente,tutor',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Nuevo ' . $request->role . ' creado exitosamente');
    }

    // 🗑️ Eliminar un usuario
    public function deleteUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado exitosamente');
    }

    // 🔄 Mover un alumno a otro grupo
    public function moveStudentToAnotherGroup(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'new_group_id' => 'required|exists:groups,id',
        ]);

        $student = User::find($request->student_id);
        $newGroup = Group::find($request->new_group_id);

        // Asociar el nuevo grupo
        $student->group()->associate($newGroup);
        $student->save();

        return redirect()->back()->with('success', 'Alumno movido a otro grupo exitosamente');
    }

    // 📝 Asignar una calificación a un alumno
    public function assignGradeToStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
        ]);

        $grade = new Grade();
        $grade->user_id = $request->student_id;
        $grade->subject_id = $request->subject_id;
        $grade->grade = $request->grade;
        $grade->save();

        return redirect()->back()->with('success', 'Nota asignada exitosamente');
    }

    // 🧾 Mostrar logs de auditoría (si usas OwenIt\Auditing)
    public function showLogs()
    {
        $logs = Audit::all();  // Se podrían filtrar o paginar
        return view('admin.logs.index', compact('logs'));
    }
}
