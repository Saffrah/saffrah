<?php

use Pusher\PushNotifications\PushNotifications;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'API Route Welcome Message',
        'response_data'    => []
    ]);
});

Route::get('/pusher', function () {

    $beamsClient = new PushNotifications([
        'instanceId' => config('services.beams.instance_id'),
        'secretKey'  => config('services.beams.secret_key'),
    ]);

    $response = $beamsClient->publishToInterests(
        ['hello'], // Replace with your actual interest(s)
        [
            'fcm' => [
                'notification' => [
                    'title' => 'Hello Pusher 2 !',
                    'body'  => 'This is a second push notification sent after setting up Pusher !',
                ],
            ],
        ]
    );

    dd($response);
});


