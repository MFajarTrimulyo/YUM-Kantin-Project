<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::redirect('/', 'home');

Route::prefix('/admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
    Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store');
    Route::get('/kategoris/{id}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
    Route::put('/kategoris/{id}', [KategoriController::class, 'update'])->name('kategoris.update');
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/home', [UserController::class, 'home'])->name('home');
Route::get('/menu', [UserController::class, 'menu'])->name('menu.index');

