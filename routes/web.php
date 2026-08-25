<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataLatihController;
use App\Http\Controllers\DataUjiController;
use App\Http\Controllers\PrediksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('data-latih')->name('data-latih.')->group(function () {
        Route::get('/', [DataLatihController::class, 'index'])->name('index');
        Route::get('/create', [DataLatihController::class, 'create'])->name('create');
        Route::post('/', [DataLatihController::class, 'store'])->name('store');
        Route::post('/import', [DataLatihController::class, 'import'])->name('import');
        Route::get('/template', [DataLatihController::class, 'template'])->name('template');
        Route::delete('/truncate', [DataLatihController::class, 'truncate'])->name('truncate');
        Route::get('/{id}/edit', [DataLatihController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DataLatihController::class, 'update'])->name('update');
        Route::delete('/{id}', [DataLatihController::class, 'destroy'])->name('destroy');
    });

    // Data Uji
    Route::prefix('data-uji')->name('data-uji.')->group(function () {
        Route::get('/', [DataUjiController::class, 'index'])->name('index');
        Route::get('/create', [DataUjiController::class, 'create'])->name('create');
        Route::post('/', [DataUjiController::class, 'store'])->name('store');
        Route::post('/import', [DataUjiController::class, 'import'])->name('import');
        Route::get('/template', [DataUjiController::class, 'template'])->name('template');
        Route::get('/{id}/edit', [DataUjiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DataUjiController::class, 'update'])->name('update');
        Route::delete('/{id}', [DataUjiController::class, 'destroy'])->name('destroy');
        Route::delete('/truncate/all', [DataUjiController::class, 'truncate'])->name('truncate');
        Route::get('/prediksi-terakhir', [DataUjiController::class, 'prediksiTerakhir'])->name('prediksi-terakhir'); // Route baru
    });

    // Prediksi
    Route::prefix('prediksi')->name('prediksi.')->group(function () {
        Route::get('/', [PrediksiController::class, 'index'])->name('index');
        Route::get('/satu/{id}', [PrediksiController::class, 'prediksiSatu'])->name('satu');
        Route::get('/semua', [PrediksiController::class, 'prediksiSemua'])->name('semua');
        Route::get('/perhitungan/{id}', [PrediksiController::class, 'perhitunganDetail'])->name('perhitungan');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

require __DIR__ . '/auth.php';
