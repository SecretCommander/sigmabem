<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\KegiatanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// ROUTE PUBLIC (TANPA LOGIN)
// ==========================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');


// ==========================================
// AUTH ROUTES
// ==========================================

// ✅ Login page - HANYA untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
});

// ✅ Login process - DENGAN RATE LIMITER (brute force protection)
Route::middleware(['guest', 'throttle'])->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// ✅ Logout - HARUS sudah login
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// ==========================================
// ROUTE YANG HARUS LOGIN (SEMUA ROLE)
// ==========================================

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});


// ==========================================
// ROUTE SUPERADMIN & ADMIN
// ==========================================

Route::middleware(['auth', 'role:Superadmin,Admin'])->group(function () {

    Route::get('/proposal', [KegiatanController::class, 'index'])->name('proposal.index');

    // Route::get('/proposal/create', function () {
    //     return view('proposal.create');
    // })->name('proposal.create');

    Route::get('/proposal/{id}/rab', [KegiatanController::class, 'show'])->name('proposal.show');
    Route::post('/proposal', [KegiatanController::class, 'store'])->name('proposal.store');
    Route::put('/proposal/{kegiatan}/edit', [KegiatanController::class, 'update'])->name('proposal.update');
    Route::delete('/proposal/{kegiatan}', [KegiatanController::class, 'destroy'])->name('proposal.destroy');

    Route::get('/lpj', function () {
        return view('lpj.index');
    })->name('lpj.index');

    Route::get('/lpj/create', function () {
        return view('lpj.create');
    })->name('lpj.create');

    Route::get('/lpj/{id}', function ($id) {
        return view('lpj.show', compact('id'));
    })->name('lpj.show');
});


// ==========================================
// ROUTE SUPERADMIN ONLY
// ==========================================

Route::middleware(['auth', 'role:Superadmin'])->group(function () {

    Route::get('/users', function () {
        $users = \App\Models\User::all();
        return view('users.index', compact('users'));
    })->name('users.index');

    Route::get('/users/create', function () {
        return view('users.create');
    })->name('users.create');

    Route::get('/users/{id}/edit', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        return view('users.edit', compact('user'));
    })->name('users.edit');

    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');

    Route::get('/activity-logs', function () {
        return view('logs.index');
    })->name('logs.index');
});


// ==========================================
// ROUTE USER ONLY
// ==========================================

Route::middleware(['auth', 'role:User'])->group(function () {

    Route::get('/my-proposals', function () {
        return view('proposal.index');
    })->name('user.proposals');

    Route::get('/my-lpj', function () {
        return view('user.lpj');
    })->name('user.lpj');
});
