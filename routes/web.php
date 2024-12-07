<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AdminController::class, 'getlogin'])->name('admin.get.login');
Route::post('/login', [AdminController::class, 'postlogin'])->name('admin.post.login');
Route::get('/register', [AdminController::class, 'getRegister'])->name('admin.get.register');
Route::post('/register', [AdminController::class, 'postRegister'])->name('admin.post.register');

Route::get('/dashboard', function () {
    return view('dashboard/dashboard');
});



Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
});
