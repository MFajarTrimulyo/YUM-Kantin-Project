<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DetailPemesananController;
use App\Http\Controllers\GeraiController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RekeningController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::redirect('/', 'home');

// Public Routes (home, kantins, about)
Route::get('/home', [UserController::class, 'home'])->name('home');

Route::get('/kantins', [UserController::class, 'listKantin'])->name('kantin.list');

Route::get('/about', [UserController::class, 'about'])->name('about');

// Login dan Register Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});


// Routes sesudah login
Route::middleware(['auth'])->group(function () {
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::get('/profile/{username}', [UserController::class, 'edit_profile'])->name('profile.edit');
    Route::put('/profile/{username}', [UserController::class, 'update_profile'])->name('profile.update');

    // Become Seller Route
    Route::post('/become-seller', [UserController::class, 'jadi_penjual'])->name('become.seller');

    

    // Admin and Seller Routes
    Route::middleware(['hak.akses:admin,penjual'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Laporan Penjualan Routes
        Route::get('{role}/laporan', [DetailPemesananController::class, 'index'])->name('laporan.index');
    });



    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout (Logic Baru)
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Orders (Riwayat)
    Route::get('/{username}/my-order', [PemesananController::class, 'order_user'])->name('pemesanan.user.index');
    Route::patch('/{username}/my-order/cancel', [PemesananController::class, 'cancelByUser'])->name('pemesanan.user.cancel');


    // Admin Routes
    Route::middleware(['hak.akses:admin'])->prefix('/admin')->group(function () {
        // Kategori Routes
        Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
        Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
        Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store');
        Route::get('/kategoris/{id}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
        Route::put('/kategoris/{id}', [KategoriController::class, 'update'])->name('kategoris.update');
        Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');

        // Kantin Routes
        Route::get('/kantins', [KantinController::class, 'index'])->name('kantins.index');
        Route::get('/kantins/create', [KantinController::class, 'create'])->name('kantins.create');
        Route::post('/kantins', [KantinController::class, 'store'])->name('kantins.store');
        Route::get('/kantins/{id}/edit', [KantinController::class, 'edit'])->name('kantins.edit');
        Route::put('/kantins/{id}', [KantinController::class, 'update'])->name('kantins.update');
        Route::delete('/kantins/{id}', [KantinController::class, 'destroy'])->name('kantins.destroy');

        // Gerai Routes
        Route::get('/gerais', [AdminController::class, 'gerai'])->name('admin.gerai.index');
        Route::post('/gerais/{id}/verify', [AdminController::class, 'verifyGerai'])->name('admin.gerai.verify');
        Route::delete('/gerais/{id}', [AdminController::class, 'destroyGerai'])->name('admin.gerai.destroy');

        // Rekening Routes
        Route::get('/rekenings', [RekeningController::class, 'index'])->name('admin.rekenings.index');
        Route::get('/rekenings/create', [RekeningController::class, 'create'])->name('admin.rekenings.create');
        Route::post('/rekenings', [RekeningController::class, 'store'])->name('admin.rekenings.store');
        Route::get('/rekenings/{id}/edit', [RekeningController::class, 'edit'])->name('admin.rekenings.edit');
        Route::put('/rekenings/{id}', [RekeningController::class, 'update'])->name('admin.rekenings.update');
        Route::delete('/rekenings/{id}', [RekeningController::class, 'destroy'])->name('admin.rekenings.destroy');
        // Route Monitoring Pesanan
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.pemesanans.index');
    });


    // Jadi Penjual Routes
    Route::get('/gerai/create', [GeraiController::class, 'createOrEdit'])->name('gerai.create');
    Route::post('/gerai/store', [GeraiController::class, 'storeOrUpdate'])->name('gerai.store');
    Route::get('/gerai/pending', [GeraiController::class, 'pending'])->name('gerai.pending');

    // Penjual Routes
    Route::middleware(['hak.akses:penjual', 'has.gerai'])->prefix('/penjual')->group(function () {
        // Produk Routes
        Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // Pemesanan Routes
        Route::get('/orders', [PemesananController::class, 'index'])->name('penjual.pemesanan.index');
        Route::patch('/orders/{id}', [PemesananController::class, 'updateStatus'])->name('penjual.pemesanan.update');
    });
});

// Public Routes (menu)
Route::get('/menu', [UserController::class, 'menu'])->name('menu.index');
Route::get('/{gerai_slug}/{produk_slug}', [UserController::class, 'show'])->name('menu.show');


