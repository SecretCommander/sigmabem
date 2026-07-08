<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LoginRateLimiter
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya untuk route login POST
        if ($request->is('login') && $request->isMethod('post')) {
            $ip = $request->ip();
            $key = 'login_attempts_' . $ip;

            // Cek apakah IP sudah diblokir
            if (Cache::has($key . '_blocked')) {
                $blockedUntil = Cache::get($key . '_blocked');
                $remainingMinutes = now()->diffInMinutes($blockedUntil);

                return back()
                    ->with('error', "Terlalu banyak percobaan login. Silakan coba lagi dalam {$remainingMinutes} menit.")
                    ->withInput($request->except('password'));
            }

            // Cek jumlah attempts
            $attempts = Cache::get($key, 0);

            if ($attempts >= 5) {
                // Blokir selama 15 menit
                Cache::put($key . '_blocked', now()->addMinutes(15), 900);
                Cache::forget($key);

                \Log::warning("IP diblokir karena terlalu banyak percobaan login", [
                    'ip' => $ip,
                    'attempts' => $attempts,
                    'blocked_until' => now()->addMinutes(15)->toDateTimeString(),
                ]);

                return back()
                    ->with('error', 'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.')
                    ->withInput($request->except('password'));
            }
        }

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        // Hanya untuk route login POST yang gagal
        if ($request->is('login') && $request->isMethod('post') && $response->isRedirection()) {
            $ip = $request->ip();
            $key = 'login_attempts_' . $ip;

            // Cek jika response redirect back (login gagal)
            if (session()->has('errors')) {
                $attempts = Cache::get($key, 0);
                Cache::put($key, $attempts + 1, 900); // Simpan 15 menit

                \Log::info("Percobaan login gagal", [
                    'ip' => $ip,
                    'attempt' => $attempts + 1,
                    'input' => $request->input('login'),
                ]);
            }
        }
    }
}
