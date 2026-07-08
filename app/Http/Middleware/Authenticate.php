<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Cek session: jika TIDAK ADA session, redirect ke login
        if (!Session::has('user_id')) {
            // Simpan URL yang ingin dituju
            Session::put('url.intended', $request->url());

            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // ✅ SESSION TIMEOUT (30 menit tidak aktif = auto logout)
        $lastActivity = Session::get('last_activity');
        $timeout = 30 * 60; // 30 menit dalam detik

        if ($lastActivity && (time() - $lastActivity > $timeout)) {
            // Log auto logout
            \Log::info("Auto logout: " . Session::get('user_username'), [
                'reason' => 'Session timeout (30 menit)',
                'last_activity' => date('Y-m-d H:i:s', $lastActivity),
                'ip' => $request->ip(),
            ]);

            Session::flush();
            Session::regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Sesi berakhir karena tidak ada aktivitas selama 30 menit. Silakan login kembali.');
        }

        // Update last activity
        Session::put('last_activity', time());

        return $next($request);
    }
}
