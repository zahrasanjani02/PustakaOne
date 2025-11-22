<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('landing');
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

//readspace
Route::get('/readspace', function () {
    return view('ReadSpace.readspace');
})->name('readspace');

//reservation
Route::get('/reservation', function () {
    return view('Reservation.reservation');
})->name('reservation');

//finedesk
Route::get('/finedesk', function () {
    return view('FineDesk.finedesk');
})->name('finedesk');

//membership
Route::get('/membership', function () {
    return view('Membership.membership');
})->name('membership');

//AboutUs
Route::get('/about', function () {
    return view('About.about');
})->name('about');

// Protected Routes - Hanya untuk yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
