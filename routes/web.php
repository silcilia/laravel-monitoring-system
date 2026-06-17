<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PowerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ======================
// AUTH (LOGIN & LOGOUT)
// ======================
Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================
// SEMUA HALAMAN HARUS LOGIN
// ======================
Route::middleware(['auth'])->group(function () {

    // ======================
    // DASHBOARD
    // ======================
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // ======================
    // SERVICES
    // ======================
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
    });

    // ======================
    // CONTACTS
    // ======================
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/create', [ContactController::class, 'create'])->name('create');
        Route::post('/', [ContactController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ContactController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ContactController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');
    });

    // ======================
    // POWER MONITORING
    // ======================
    Route::get('/power', [PowerController::class, 'index'])->name('power.index');
});