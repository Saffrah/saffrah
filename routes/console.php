<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\MonthlyIncome;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule your custom command
Artisan::command('income:monthly', function () {
    // Call your custom command directly here (or use a closure)
    $this->call(MonthlyIncome::class);
})->purpose('Sum the income for the last month')->monthlyOn(1, '00:00'); // Run on the 1st of every month at midnight
