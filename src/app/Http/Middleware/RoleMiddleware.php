<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Este middleware verifica si el usuario autenticado tiene uno de los roles permitidos
     * para acceder a una ruta específica.
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // 🧩 Convertir el string de roles separados por coma en un array
        // Ejemplo: "admin,docente" → ['admin', 'docente']
        $roles = explode(',', $roles);

        // ✅ Verificar si el usuario está autenticado y su rol está en la lista permitida
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            // Si el rol es válido, continuar con la petición
            return $next($request);
        }

        // ❌ Si no tiene permiso, abortar con error 403 (Prohibido)
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}
