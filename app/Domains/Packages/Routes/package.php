<?php

namespace App\Domains\Packages\Routes;

use App\Domains\Packages\Controllers\PackageController;
use App\Http\Middleware\CompanyMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'This Package Domain !',
        'response_data'    => []
    ]);
});
Route::middleware(['auth:sanctum', UserMiddleware::class])->group(function () {
    Route::get('all_packages', [PackageController::class, 'all_packages']);
});

Route::middleware(['auth:sanctum', CompanyMiddleware::class])->group(function () {
    Route::get('destinations', [PackageController::class, 'destinations']);
    Route::get('package/{package_id}', [PackageController::class, 'get_package']);
    Route::get('company/all', [PackageController::class, 'get_company_packages']);
    Route::post('store', [PackageController::class, 'store']);
    Route::post('update', [PackageController::class, 'edit']);
    Route::post('delete', [PackageController::class, 'delete']);
});
