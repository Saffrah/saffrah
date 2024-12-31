<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfferController;
use App\Http\Middleware\AdminMiddleware;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.get.login');
});

Route::get('/login', [AdminController::class, 'getlogin'])->name('admin.get.login');
Route::post('/login', [AdminController::class, 'postlogin'])->name('admin.post.login');
Route::get('/register', [AdminController::class, 'getRegister'])->name('admin.get.register');
Route::post('/register', [AdminController::class, 'postRegister'])->name('admin.post.register');

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.get');
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.get');
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.get');
});
