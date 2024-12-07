<?php

use App\Http\Middleware\CompanyMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
        ->withRouting(
            commands: __DIR__.'/../routes/console.php',
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('api')
                ->prefix('api/auth')
                ->group(base_path('app/Domains/Auth/Routes/auth.php'));

            Route::middleware('api')
                ->prefix('api/company')
                ->group(base_path('app/Domains/Company/Routes/company.php'));
            
            Route::middleware('api')
                ->prefix('api/file_manager')
                ->group(base_path('app/Domains/FileManager/Routes/file.php'));

            Route::middleware('api')
                ->prefix('api/packages')
                ->group(base_path('app/Domains/Packages/Routes/package.php'));

            Route::middleware('api')
                ->prefix('api/offers')
                ->group(base_path('app/Domains/Offers/Routes/offer.php'));
    
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
