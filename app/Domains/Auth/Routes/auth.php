<?php

namespace App\Domains\Auth\Routes;

use App\Domains\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'This Auth Domain !',
        'response_data'    => []
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/forgot_password', [AuthController::class, 'forgotPassword']);
