<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use OwenIt\Auditing\Models\Audit;

class LogController extends Controller
{
    public function index()
    {
        $logs = Audit::with('user')->latest()->paginate(20); // Paginación

        return view('admin.logs.index', compact('logs'));
    }
}
