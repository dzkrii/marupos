<?php

use App\Http\Middleware\EnsureOutletAccess;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SetCurrentOutlet;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'outlet.access' => EnsureOutletAccess::class,
            'outlet.switch' => SetCurrentOutlet::class,
        ]);

        // Add outlet middleware to web group
        $middleware->web(append: [
            SetCurrentOutlet::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

