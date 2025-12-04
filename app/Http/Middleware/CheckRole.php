<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // verifica el el rol del usuario con la ruta que intenta acceder
        if ($request->user()->role !== $role && $request->user()->role !== 'admin') {
        abort(403, 'Prohibido el acceso a esta pagina');
    }
        return $next($request);
    }
}
