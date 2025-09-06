<?php

use App\Http\Middleware\AuthenticationMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);


        $middleware->alias([
            'auth.user' => AuthenticationMiddleware::class,
            'validate.category' => \App\Http\Middleware\ValidateCategory::class,
            'validate.subcategory'=> \App\Http\Middleware\ValidateSubcategory::class,
             'admin'=>\App\Http\Middleware\AdminMiddleware::class,
             'validate.product'=> \App\Http\Middleware\ValidateProduct::class

]);




     

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
