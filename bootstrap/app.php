<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\HandleInertiaRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',  
    )
    ->withMiddleware(function ($middleware) {
        $middleware->web([
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {
        // Custom exception handling logic (if any), leave empty otherwise
    })
    ->create();