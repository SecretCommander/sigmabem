<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Cek session: jika SUDAH ADA session, redirect ke dashboard
        if (Session::has('user_id')) {
            return redirect()->route('dashboard')
                ->with('info', 'Anda sudah login sebagai ' . Session::get('user_username'));
        }

        return $next($request);
    }
}
