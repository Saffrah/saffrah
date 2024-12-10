<?php

namespace App\Broadcasting;

use Pusher\PushNotifications\PushNotifications;
use App\Models\User;

class PusherBeamsChannel
{
    public function send($notifiable, $notification)
    {
        $data  = $notification->toPusher($notifiable);

        $beams = new PushNotifications([
            'instanceId' => config('services.pusher.instance_id'),
            'secretKey'  => config('services.pusher.secret_key'),
        ]);

        return $beams->publishToInterests(
            [$data['interest']],
            [
                'fcm' => $data['fcm'],
                'apns' => $data['apns'],
            ]
        );
    }
    
}
