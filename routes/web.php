<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\HafalanController;

use App\Http\Controllers\Auth\RegisterController;

// Public Routes
// Public Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

// Public Menu
Route::get('/unit-usaha-public', [App\Http\Controllers\UnitUsahaController::class, 'index'])->name('unit_usaha.public');

Route::middleware(['auth'])->group(function () {
    // Global Access (All Roles)
    Route::resource('threads', App\Http\Controllers\ThreadController::class);
    Route::post('threads/{thread}/reply', [App\Http\Controllers\ThreadController::class, 'reply'])->name('threads.reply');
    
    Route::resource('messages', App\Http\Controllers\ChatController::class);

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Unit Usaha (Read for all, Create/Edit for Admin via gate/middleware check in controller or route)
    Route::get('/unit-usaha', [App\Http\Controllers\UnitUsahaController::class, 'index'])->name('unit_usaha.index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes - Wali Santri
Route::middleware(['auth', 'role:wali_santri'])->prefix('wali')->name('wali.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'waliDashboard'])->name('dashboard');
    Route::get('/pembayaran', [PembayaranController::class, 'indexWali'])->name('pembayaran');
    Route::post('/pembayaran', [PembayaranController::class, 'storeWali'])->name('pembayaran.store');
    Route::get('/hafalan', [HafalanController::class, 'indexWali'])->name('hafalan');
});

// Protected Routes - Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // Unit Usaha Management
    Route::resource('unit-usaha', App\Http\Controllers\UnitUsahaController::class)->except(['index', 'show']);

    // Santri Management
    Route::put('santri/{santri}/graduate', [SantriController::class, 'graduate'])->name('santri.graduate');
    Route::resource('santri', SantriController::class);
    Route::get('santri/import/form', [SantriController::class, 'importForm'])->name('santri.import.form');
    Route::post('santri/import', [SantriController::class, 'import'])->name('santri.import');
    
    // Pembayaran Management
    Route::resource('pembayaran', PembayaranController::class);
    
    // Hafalan Management
    Route::resource('hafalan', HafalanController::class);

    // User Management
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Settings
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
});

// Protected Routes - Ustadz
Route::middleware(['auth', 'role:ustadz'])->prefix('ustadz')->name('ustadz.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'ustadzDashboard'])->name('dashboard');
    Route::resource('hafalan', HafalanController::class)->except(['destroy']); // Allow everything except delete
});

// Protected Routes - Pengurus
Route::middleware(['auth', 'role:pengurus'])->prefix('pengurus')->name('pengurus.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pengurusDashboard'])->name('dashboard');
    Route::resource('tagihan', \App\Http\Controllers\TagihanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/verifikasi', [PembayaranController::class, 'verifikasiIndex'])->name('pembayaran.verifikasi');
    Route::post('/verifikasi/{pembayaran}', [PembayaranController::class, 'verifikasiAction'])->name('pembayaran.verifikasi.action');
    Route::get('/laporan', [PembayaranController::class, 'laporan'])->name('laporan');
});
