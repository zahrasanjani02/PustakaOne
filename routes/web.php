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
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/readspace', [ReadSpaceController::class, 'index'])->name('readspace');
Route::get('/readspace/book/{id}', [ReadSpaceController::class, 'show'])->name('readspace.show');


// ===== AUTHENTICATED ROUTES (Member & Admin) =====
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ReadSpace User Actions
    Route::post('/readspace/favorite/{bookId}', [ReadSpaceController::class, 'toggleFavorite'])->name('readspace.favorite');
    Route::post('/readspace/borrow/{bookId}', [ReadSpaceController::class, 'borrowBook'])->name('readspace.borrow');
    
    // Reservation User View
    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
    Route::post('/reservation/request-return/{borrowingId}', [ReservationController::class, 'requestReturn'])->name('reservation.requestReturn');
    // Route untuk Member Perpanjang Sendiri
    Route::post('/reservation/extend-self/{id}', [ReservationController::class, 'extendSelf'])->name('reservation.extendSelf');
    
    // FineDesk User View
    Route::get('/finedesk', [FineDeskController::class, 'index'])->name('finedesk');
    
    // Membership Index (Bisa diakses Member untuk lihat profil, Admin untuk lihat list)
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Route Form Renew
    Route::get('/membership/renew', [MembershipController::class, 'renewForm'])->name('membership.renew');
    // Route Submit Renew
    Route::post('/membership/renew', [MembershipController::class, 'renewProcess'])->name('membership.renewProcess');
});


// ===== ADMIN ONLY ROUTES =====
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // About Us Edit
    Route::get('about/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('about/update', [AboutController::class, 'update'])->name('about.update');
    
    // ReadSpace Management (Create, Edit, Delete)
    Route::get('/readspace/create', [ReadSpaceController::class, 'create'])->name('readspace.create');
    Route::post('/readspace', [ReadSpaceController::class, 'store'])->name('readspace.store');
    Route::get('/readspace/book/{id}/edit', [ReadSpaceController::class, 'edit'])->name('readspace.edit');
    Route::put('/readspace/book/{id}', [ReadSpaceController::class, 'update'])->name('readspace.update');
    Route::delete('/admin/books/{id}', [ReadSpaceController::class, 'destroy'])->name('readspace.destroy');

    // Reservation Management
    Route::post('/reservation/mark-returned/{borrowingId}', [ReservationController::class, 'markReturned'])->name('reservation.markReturned');
    Route::post('/reservation/extend/{id}', [ReservationController::class, 'extend'])->name('reservation.extend');

    // FineDesk Management
    Route::post('/finedesk/mark-paid/{borrowingId}', [FineDeskController::class, 'markPaid'])->name('finedesk.markPaid');

    // Membership Management (Create, Edit, Update, Destroy)
    // PENTING: Kita pakai 'except' index dan show, karena index sudah ada di atas (public/auth)
    Route::resource('membership', MembershipController::class)->except(['index', 'show']);
});