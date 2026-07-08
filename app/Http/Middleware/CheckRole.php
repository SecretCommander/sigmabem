<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // ✅ Cek session
        if (!Session::has('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Session::get('user_role');
        $userName = Session::get('user_username');

        // Cek apakah role diizinkan
        if (!in_array($userRole, $roles)) {
            // Log unauthorized access
            \Log::warning("Unauthorized access: {$userName} ({$userRole}) tried to access " . $request->url());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Anda tidak memiliki akses.'
                ], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', "Akses ditolak! Role {$userRole} tidak diizinkan.");
        }

        return $next($request);
    }
}
