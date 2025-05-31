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
    public function index()
{
    $docente = auth()->user();

    $groups = Group::whereHas('subjects', function ($query) use ($docente) {
        $query->where('teacher_id', $docente->id);
    })->with(['subjects' => function ($query) use ($docente) {
        $query->where('teacher_id', $docente->id);
    }])->get();

    $attendances = Attendance::whereIn('subject_id', function ($query) use ($docente) {
        $query->select('id')
              ->from('subjects')
              ->where('teacher_id', $docente->id);
    })->with(['user', 'subject'])->orderBy('date', 'desc')->get();

    return view('docente.asistencia.index', compact('groups', 'attendances'));
}



   public function create(Request $request)
    {
        $docente = auth()->user();

        $groups = Group::whereHas('subjects', function ($query) use ($docente) {
            $query->where('teacher_id', $docente->id);
        })->with(['subjects' => function ($query) use ($docente) {
            $query->where('teacher_id', $docente->id);
        }, 'students'])->get();

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
            'subject_id' => 'required|exists:subjects,id', // Asegúrate de que la asignatura exista
            'date' => 'required|date', // Asegúrate de que la fecha esté bien definida
            'status' => 'required|array', // Asegúrate de que los estados sean un array
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




   public function edit(Attendance $attendance)
    {
        $attendance->load(['user', 'subject']);

        return view('docente.asistencia.edit', compact('attendance'));
    }

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

    public function seleccionarClase()
    {
        $docente = auth()->user();

        $clases = \App\Models\Group::whereHas('subjects', function ($q) use ($docente) {
            $q->where('teacher_id', $docente->id);
        })->get();

        return view('docente.asistencia.seleccionar_clase', compact('clases'));
}

    public function pasarLista(\App\Models\Group $group)
    {
        $docente = auth()->user();

        $subjects = $group->subjects()->where('teacher_id', $docente->id)->get();
        $students = $group->students;

        return view('docente.asistencia.pasar_lista', compact('group', 'subjects', 'students'));
    }
   public function verAsistenciaAlumno(Request $request)
    {
        $alumno = auth()->user();

        $query = Attendance::where('user_id', $alumno->id)->with('subject');

        // Filtros dinámicos
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

        // Estadísticas
        $stats = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
        ];

        // Asignaturas para el filtro
        $subjects = Subject::whereHas('attendances', fn($q) => $q->where('user_id', $alumno->id))->get();

        return view('alumno.asistencia.index', compact('attendances', 'subjects', 'stats'));
    }

     
    public function justificar($attendanceId, Request $request)
    {
        // Validar el motivo de la justificación
        $request->validate([
            'motivo' => 'required|string|max:255',
        ]);

        // Buscar la entrada de asistencia, asumiendo que ya tenemos una entrada
        $attendance = Attendance::findOrFail($attendanceId);
        
        // Aquí asociamos el usuario y la asignatura
        $user = $attendance->user; // Obtener el usuario (alumno)
        $subject = $attendance->subject; // Obtener la asignatura relacionada con esta asistencia
        
        // Verificamos si ya existe una justificación para el usuario y asignatura
        $justificacion = Justificacion::where('user_id', $user->id)
                                      ->where('subject_id', $subject->id)
                                      ->first();

        if ($justificacion) {
            // Si ya existe, actualizamos la justificación
            $justificacion->motivo = $request->motivo;
            $justificacion->estado = 'pendiente'; // O el estado que corresponda
            $justificacion->save();
        } else {
            // Si no existe, creamos una nueva justificación
            Justificacion::create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
                'motivo' => $request->motivo,
                'estado' => 'pendiente', // Estado inicial
                'date' => now(), // Fecha actual de la justificación
            ]);
        }

        return redirect()->route('alumno.asistencia')->with('success', 'Falta justificada correctamente');
    }




}
