<?php

use App\Http\Controllers\CompanyController;
use Pusher\PushNotifications\PushNotifications;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'API Route Welcome Message',
        'response_data'    => []
    ]);
});

Route::post('/companies/update_status', [CompanyController::class, 'update'])->name('companies.update.status');

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


