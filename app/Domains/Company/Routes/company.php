<?php

namespace App\Domains\Company\Routes;

use App\Domains\Company\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'This Company Domain !',
        'response_data'    => []
    ]);
});

Route::post('/register', [CompanyController::class, 'register']);
Route::post('/login', [CompanyController::class, 'login']);
