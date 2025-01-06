<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfferController;
use App\Http\Middleware\AdminMiddleware;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.get.login');
});

Route::get('/login', [AdminController::class, 'getlogin'])->name('admin.get.login');
Route::post('/login', [AdminController::class, 'postlogin'])->name('admin.post.login');
// Route::get('/register', [AdminController::class, 'getRegister'])->name('admin.get.register');
// Route::post('/register', [AdminController::class, 'postRegister'])->name('admin.post.register');

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.get');
    Route::get('/companies/{company_id}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.get');
    Route::get('/deals', [PackageController::class, 'show'])->name('deals.get');
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.get');
});

Route::middleware([AdminMiddleware::class, 'role:super_admin'])->group(function () {
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.get');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins/store', [AdminController::class, 'store'])->name('admins.store');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.get');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/store', [MessageController::class, 'store'])->name('messages.store');
});
