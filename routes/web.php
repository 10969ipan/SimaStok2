<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Halaman beranda backend (butuh login)
Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])
    ->middleware('auth')
    ->name('backend.beranda');

// Halaman login (GET)
Route::get('backend/login', [LoginController::class, 'loginBackend'])
    ->name('backend.login');

// Proses login (POST)
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])
    ->name('backend.login.process');

// Logout (POST)
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])
    ->name('backend.logout');

// CRUD User (Resource Controller)
Route::resource('backend/user', UserController::class, ['as' => 'backend']);
