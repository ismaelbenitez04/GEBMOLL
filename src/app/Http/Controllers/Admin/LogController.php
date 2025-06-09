<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use OwenIt\Auditing\Models\Audit;

class LogController extends Controller
{
    // 🧾 Muestra el historial de auditorías (logs)
    public function index()
    {
        // Recupera los registros de auditoría más recientes y carga también el usuario asociado
        // Se usa paginación para no mostrar demasiados registros de golpe (20 por página)
        $logs = Audit::with('user')->latest()->paginate(20);

        // Retorna la vista donde se muestran los logs de auditoría
        return view('admin.logs.index', compact('logs'));
    }
}
