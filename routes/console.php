<?php

use App\Console\Commands\DeletePackagesCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\MonthlyIncome;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('income:monthly', function () {
    $this->call(MonthlyIncome::class);
})->purpose('Sum the income for the last month')->monthlyOn(1, '00:00'); // Run on the 1st of every month at midnight

Artisan::command('packages:delete', function () {
    $this->call(DeletePackagesCommand::class);
})->purpose('Delete Expired packages and offers')->dailyAt('00:00'); // Run daily at midnight
