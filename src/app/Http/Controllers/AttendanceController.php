<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Subject;
use App\Models\Justificacion;
use App\Models\Group;
use App\Models\User;


class AttendanceController extends Controller
{
    // Mostrar todas las asistencias registradas por el docente
    public function index()
    {
        $docente = auth()->user();
        // Obtenemos los grupos donde el docente tiene asignaturas
        $groups = Group::whereHas('subjects', function ($query) use ($docente) {
            $query->where('teacher_id', $docente->id);
        })->with(['subjects' => function ($query) use ($docente) {
            $query->where('teacher_id', $docente->id);
        }])->get();
        // Obtenemos asistencias de asignaturas del docente
        $attendances = Attendance::whereIn('subject_id', function ($query) use ($docente) {
            $query->select('id')
                ->from('subjects')
                ->where('teacher_id', $docente->id);
        })->with(['user', 'subject'])->orderBy('date', 'desc')->get();

        return view('docente.asistencia.index', compact('groups', 'attendances'));
    }
    // Formulario para registrar nuevas asistencias
   public function create(Request $request)
    {
        $docente = auth()->user();

        $groups = Group::whereHas('subjects', function ($query) use ($docente) {
            $query->where('teacher_id', $docente->id);
        })->with(['subjects' => function ($query) use ($docente) {
            $query->where('teacher_id', $docente->id);
        }, 'students'])->get();
        // Recopilar todos los alumnos de los grupos

        $students = collect();
        foreach ($groups as $group) {
            foreach ($group->students as $student) {
                $students->push($student);
            }
        }

        return view('docente.asistencia.create', compact('groups', 'students'));
    }
   public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'subject_id' => 'required|exists:subjects,id', 
            'date' => 'required|date', 
            'status' => 'required|array', 
        ]);

        // Guardar la asistencia de los estudiantes
        foreach ($request->status as $userId => $status) {
            $isPresent = in_array($status, ['present', 'late']) ? 1 : 0;
            // Verificamos que el estado sea uno de los valores válidos
            if (!in_array($status, ['present', 'absent', 'late'])) {
                continue;  // Si el valor del estado no es correcto, pasamos al siguiente
            }
            
            
            // Crear una nueva entrada de asistencia
            Attendance::create([
                'user_id' => $userId,          // ID del estudiante
                'subject_id' => $request->subject_id,  // Asignatura de la clase
                'date' => $request->date,     // Fecha de la clase
                'status' => $status,           // Estado: "present", "absent", "late"
                'present' => $isPresent, // Aquí se asigna 1 si es 'present' o 'late', 0 si no
            ]);
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('asistencia.index')->with('success', 'Asistencia registrada correctamente.');
    }




     // ✏️ Formulario para editar una asistencia específica
    public function edit(Attendance $attendance)
    {
        $attendance->load(['user', 'subject']);
        return view('docente.asistencia.edit', compact('attendance'));
    }

    // 🔁 Guardar cambios en una asistencia
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|string|in:present,absent,late',
        ]);

        $attendance->update([
            'date' => $request->input('date'),
            'present' => in_array($request->input('status'), ['present', 'late']),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('asistencia.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    // 📌 Seleccionar grupo para pasar lista
    public function seleccionarClase()
    {
        $docente = auth()->user();

        $clases = Group::whereHas('subjects', function ($q) use ($docente) {
            $q->where('teacher_id', $docente->id);
        })->get();

        return view('docente.asistencia.seleccionar_clase', compact('clases'));
    }

    // ✅ Mostrar formulario de pasar lista para un grupo
    public function pasarLista(Group $group)
    {
        $docente = auth()->user();

        $subjects = $group->subjects()->where('teacher_id', $docente->id)->get();
        $students = $group->students;

        return view('docente.asistencia.pasar_lista', compact('group', 'subjects', 'students'));
    }

    // 👨‍🎓 Vista del alumno para consultar su asistencia
    public function verAsistenciaAlumno(Request $request)
    {
        $alumno = auth()->user();

        $query = Attendance::where('user_id', $alumno->id)->with('subject');

        // Filtros por asignatura y fechas
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->to_date);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        // Contar asistencias por estado
        $stats = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
        ];

        $subjects = Subject::whereHas('attendances', fn($q) => $q->where('user_id', $alumno->id))->get();

        return view('alumno.asistencia.index', compact('attendances', 'subjects', 'stats'));
    }

    // 📝 Justificar una falta desde el alumno
    public function justificar($attendanceId, Request $request)
    {
        $request->validate([
            'motivo' => 'required|string|max:255',
        ]);

        $attendance = Attendance::findOrFail($attendanceId);

        $user = $attendance->user;
        $subject = $attendance->subject;

        // Verificar si ya existe una justificación previa
        $justificacion = Justificacion::where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->first();

        if ($justificacion) {
            // Actualizar justificación existente
            $justificacion->motivo = $request->motivo;
            $justificacion->estado = 'pendiente';
            $justificacion->save();
        } else {
            // Crear nueva justificación
            Justificacion::create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
                'motivo' => $request->motivo,
                'estado' => 'pendiente',
                'date' => now(),
            ]);
        }

        return redirect()->route('alumno.asistencia')->with('success', 'Falta justificada correctamente');
    }

}
