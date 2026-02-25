<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ REGISTER YOUR ALIAS HERE
        $middleware->alias([
            'username.match' => \App\Http\Middleware\UsernameMustMatchAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ✅ DO NOT REMOVE THIS BLOCK (even if empty)
    })
    ->create();