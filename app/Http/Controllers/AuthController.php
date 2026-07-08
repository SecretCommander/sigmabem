<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi: username ATAU email + password
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Cek apakah input adalah email atau username
        $login = $credentials['login'];
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'Email' : 'Username';

        // Cari user berdasarkan email atau username
        $user = \App\Models\User::where($field, $login)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => 'Akun tidak ditemukan.']);
        }

        // Verifikasi password
        if (!Hash::check($credentials['password'], $user->Password)) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors(['password' => 'Password salah.']);
        }

        // ✅ RESET RATE LIMITER PADA LOGIN SUKSES
        $ip = $request->ip();
        \Illuminate\Support\Facades\Cache::forget('login_attempts_' . $ip);
        \Illuminate\Support\Facades\Cache::forget('login_attempts_' . $ip . '_blocked');

        // ✅ SIMPAN DATA USER KE SESSION
        Session::put('user_id', $user->ID_Pengguna);
        Session::put('user_username', $user->Username);
        Session::put('user_email', $user->Email);
        Session::put('user_role', $user->Role);
        Session::put('user_login_time', now()->toDateTimeString());
        Session::put('last_activity', time()); // ✅ Untuk session timeout
        Session::put('user_ip', $request->ip());
        Session::put('user_agent', $request->userAgent());

        // Remember Me
        if ($request->boolean('remember')) {
            Session::put('user_remember', true);
            cookie()->queue('remember_login', $login, 43200); // 30 hari
        }

        // Regenerate session ID
        Session::regenerate();

        // Update status online di database
        $user->update([
            'is_active' => now()->toDateString(),
            'Last_login' => now(),
        ]);

        // Log aktivitas
        \Log::info("User login SUCCESS: {$user->Username} ({$user->Role})", [
            'email' => $user->Email,
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);

        // Redirect ke dashboard
        return redirect()->route('dashboard')
            ->with('success', "Selamat datang, {$user->Username}!");
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        $username = Session::get('user_username');

        // Log aktivitas
        \Log::info("User logout: {$username}", [
            'email' => Session::get('user_email'),
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);

        // Hapus semua session
        Session::flush();
        Session::regenerateToken();

        // Hapus cookie remember
        cookie()->queue(cookie()->forget('remember_login'));

        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
