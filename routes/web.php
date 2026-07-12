<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\SieController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

    Route::post('/proposal/tambah-sie', [SieController::class, 'store'])->name('Sie.store');
    Route::put('/proposal/edit-sie/{sie}', [SieController::class, 'update'])->name('Sie.update');
    Route::delete('/proposal/hapus-sie/{sie}', [SieController::class, 'destroy'])->name('Sie.destroy');

    Route::post('/proposal/tambah-item', [ItemController::class, 'store'])->name('Item.store');
    Route::put('/proposal/edit-item/{item}', [ItemController::class, 'update'])->name('Item.update');
    Route::delete('/proposal/hapus-item/{item}', [ItemController::class, 'destroy'])->name('Item.destroy');

    Route::get('/proposal/{id}/export-pdf', [KegiatanController::class, 'exportPdfRab'])->name('proposal.export.pdf');
    Route::get('/proposal/{id}/export-excel', [KegiatanController::class, 'exportExcelRab'])->name('proposal.export.excel');

    Route::get('/lpj', [KegiatanController::class, 'index'])->name('lpj.index');
    Route::post('/lpj/tambah-bon', [BonController::class, 'store'])->name('Bon.store');

    Route::get('/lpj/bon/{bon}/detail', [BonController::class, 'getDetail'])->name('Bon.detail');

    Route::put('/lpj/edit-bon/{bon}', [BonController::class, 'update'])->name('Bon.update');
    Route::delete('/lpj/hapus-bon/{bon}', [BonController::class, 'destroy'])->name('Bon.destroy');

    Route::get('/lpj/{id}/export-pdf', [KegiatanController::class, 'exportPdf'])->name('lpj.export.pdf');
    Route::get('/lpj/{id}/export-excel', [KegiatanController::class, 'exportExcel'])->name('lpj.export.excel');

    Route::get('/lpj/create', function () {
        return view('lpj.create');
    })->name('lpj.create');

    Route::get('/lpj/{id}/rab', [KegiatanController::class, 'show'])->name('lpj.show');
});

// ==========================================
// ROUTE SUPERADMIN ONLY
// ==========================================

Route::middleware(['auth', 'role:Superadmin'])->group(function () {

    Route::get('/users', function () {
        $users = User::all();

        return view('users.index', compact('users'));
    })->name('users.index');

    Route::get('/users/create', function () {
        return view('users.create');
    })->name('users.create');

    Route::get('/users/{id}/edit', function ($id) {
        $user = User::findOrFail($id);

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
