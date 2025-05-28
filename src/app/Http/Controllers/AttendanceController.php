<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Subject;
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
        $exists = Attendance::where('user_id', $userId)
            ->where('subject_id', $subjectId)
            ->where('date', $date)
            ->exists();

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'status' => 'array',
        ]);
        

       foreach ($request->status ?? [] as $userId => $status) {
            logger("ID: $userId - Status: $status");
            dd($status, in_array($status, ['presente', 'retraso']));
            Attendance::create([
                'user_id' => $userId,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
                'status' => $status,
                'present' => in_array($status, ['present', 'late']), 
            ]);
        }

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



}
