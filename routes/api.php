<?php

use Pusher\PushNotifications\PushNotifications;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'API Route Welcome Message',
        'response_data'    => []
    ]);
});

Route::post('/companies/update_percentage', [CompanyController::class, 'edit'])->name('companies.edit.percentage');
Route::post('/companies/update_status', [CompanyController::class, 'update'])->name('companies.update.status');
Route::post('/companies/delete', [CompanyController::class, 'destroy'])->name('companies.delete');
Route::post('/packages/delete', [PackageController::class, 'destroy'])->name('packages.delete');
Route::post('/offers/delete', [OfferController::class, 'destroy'])->name('offers.delete');
Route::post('/admins/delete', [AdminController::class, 'destroy'])->name('admins.delete');
Route::post('/messages/delete', [MessageController::class, 'destroy'])->name('messages.delete');

Route::get('/pusher', function () {

    $beamsClient = new PushNotifications([
        'instanceId' => config('services.pusher.instance_id'),
        'secretKey'  => config('services.pusher.secret_key'),
    ]);

    $response = $beamsClient->publishToInterests(
        ['user_int_0022'], // Replace with your actual interest(s)
        [
            'fcm' => [
                'notification' => [
                    'title' => 'Hello Eslam !',
                    'body'  => 'This is a push notification sent from local to test the interest !!',
                ],
            ],
        ]
    );

    dd($response);
});


