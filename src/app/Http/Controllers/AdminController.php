<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;

class AdminController extends Controller
{
    public function addStudentToGroup(Request $request)
    {
        // Validar datos
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id',
        ]);

        $student = User::find($request->student_id);
        $group = Group::find($request->group_id);

        // Asociar al alumno con el grupo
        $student->group()->associate($group);
        $student->save();

        return redirect()->back()->with('success', 'Alumno agregado al grupo exitosamente');
    }

    public function removeStudentFromGroup(Request $request)
    {
        // Validar datos
        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::find($request->student_id);

        // Eliminar asociación con el grupo
        $student->group()->dissociate();
        $student->save();

        return redirect()->back()->with('success', 'Alumno eliminado del grupo exitosamente');
    }


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

    public function deleteUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado exitosamente');
    }

    public function moveStudentToAnotherGroup(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'new_group_id' => 'required|exists:groups,id',
        ]);

        $student = User::find($request->student_id);
        $newGroup = Group::find($request->new_group_id);

        // Mover al alumno al nuevo grupo
        $student->group()->associate($newGroup);
        $student->save();

        return redirect()->back()->with('success', 'Alumno movido a otro grupo exitosamente');
    }
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

    public function showLogs()
    {
        $logs = Audit::all();  // O usa tu filtro de logs
        return view('admin.logs.index', compact('logs'));
    }

}
