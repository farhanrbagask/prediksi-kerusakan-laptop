<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataLatihController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/data-latih', [DataLatihController::class, 'index'])
        ->name('data-latih.index');

    Route::get('/data-latih/create', [DataLatihController::class, 'create'])
        ->name('data-latih.create');

    Route::post('/data-latih', [DataLatihController::class, 'store'])
        ->name('data-latih.store');

    Route::get('/data-latih/{dataLatih}', [DataLatihController::class, 'show'])
        ->name('data-latih.show');

    Route::get('/data-latih/{dataLatih}/edit', [DataLatihController::class, 'edit'])
        ->name('data-latih.edit');

    Route::put('/data-latih/{dataLatih}', [DataLatihController::class, 'update'])
        ->name('data-latih.update');

    Route::delete('/data-latih/{dataLatih}', [DataLatihController::class, 'destroy'])
        ->name('data-latih.destroy');
});