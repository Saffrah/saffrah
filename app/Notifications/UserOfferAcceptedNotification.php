<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserOfferAcceptedNotification extends Notification
{
    use Queueable;

    protected $company;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param $user
     */
    public function __construct($user, $company)
    {
        $this->company = $company;
        $this->user    = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['pusher'];
    }

    /**
     * Send the notification via Pusher Beams.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPusher($notifiable)
    {
        return [
            'interest' => 'user_int_00' . $this->user->id,
            'fcm' => [
                'notification' => [
                    'title' => 'Congrats, Your Offer got Accepted!',
                    'body' => "Hi {$this->user->name}, {$this->company->name} Accepted your offer, login to check their package!",
                ],
            ],
            'apns' => [
                'aps' => [
                    'alert' => [
                        'title' => 'Congrats, Your Offer got Accepted!',
                        'body' => "Hi {$this->user->name}, {$this->company->name} Accepted your offer, login to check their package!",
                    ],
                ],
            ],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
