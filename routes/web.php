<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReadSpaceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FineDeskController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('LandingPage.landing');
})->name('home');

// ===== AUTH ROUTES =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'handleRegister']);

// ===== PUBLIC ROUTES =====
Route::get('/about', function () {
    return view('About.about');
})->name('about');

Route::get('/readspace', [ReadSpaceController::class, 'index'])->name('readspace');
Route::get('/readspace/book/{id}', [ReadSpaceController::class, 'show'])->name('readspace.show');

// ===== AUTHENTICATED ROUTES (SEMUA YANG LOGIN - Admin & Member) =====
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ReadSpace features
    Route::post('/readspace/favorite/{bookId}', [ReadSpaceController::class, 'toggleFavorite'])->name('readspace.favorite');
    Route::post('/readspace/borrow/{bookId}', [ReadSpaceController::class, 'borrowBook'])->name('readspace.borrow');
    
    // Reservation
    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
    Route::post('/reservation/request-return/{borrowingId}', [ReservationController::class, 'requestReturn'])->name('reservation.requestReturn');
    
    // Reservation Admin only
    Route::middleware('role:admin')->group(function () {
        Route::post('/reservation/mark-returned/{borrowingId}', [ReservationController::class, 'markReturned'])->name('reservation.markReturned');
    });
    
    // FineDesk
    Route::get('/finedesk', [FineDeskController::class, 'index'])->name('finedesk');
    
    // FineDesk Admin only
    Route::middleware('role:admin')->group(function () {
        Route::post('/finedesk/mark-paid/{borrowingId}', [FineDeskController::class, 'markPaid'])->name('finedesk.markPaid');
    });
    
    // Membership
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership');

    // About Us
Route::get('/about', [AboutController::class, 'index'])->name('about');

// About Us Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
});

// Favorite Routes
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});
