<?php

namespace App\Providers;

use Illuminate\Support\Facades\Notification;
use App\Broadcasting\PusherBeamsChannel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Notification::extend('pusher', function () {
            return new PusherBeamsChannel();
        });

        Gate::define('super_admin', function ($user) {
            return $user->role === 'super_admin';
        });
    }
}
