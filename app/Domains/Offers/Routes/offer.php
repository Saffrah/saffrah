<?php

namespace App\Domains\Offers\Routes;

use App\Domains\Offers\Controllers\OfferController;
use App\Http\Middleware\CompanyMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'This Offer Domain !',
        'response_data'    => []
    ]);
});

Route::middleware(['auth:sanctum', CompanyMiddleware::class])->group(function () {
    Route::get('all_offers', [OfferController::class, 'all_packages']);
});

Route::middleware(['auth:sanctum', UserMiddleware::class])->group(function () {
    Route::get('offer/{offer_id}', [OfferController::class, 'get_offer']);
    Route::get('user/all', [OfferController::class, 'get_user_offers']);
    Route::post('store', [OfferController::class, 'store']);
    Route::post('update', [OfferController::class, 'edit']);
    Route::post('delete', [OfferController::class, 'delete']);
});
