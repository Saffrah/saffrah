<?php

use Illuminate\Support\Facades\Route;

// Controller as a director
use App\Domains\FileManager\Controllers\FileManagerController;
use App\Http\Middleware\CompanyMiddleware;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [FileManagerController::class, 'index'])->name('file_manager.index');
    Route::post('/', [FileManagerController::class, 'store'])->name('file_manager.store');
    Route::get('/all/{report_id?}', [FileManagerController::class, 'show']);
    Route::delete('/{id}', [FileManagerController::class, 'destroy'])->name('file_manager.delete');
    Route::get('/change-file-status/{id}', [FileManagerController::class, 'changeFileStatus']);
});