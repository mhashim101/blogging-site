<?php

use App\Http\Middleware\ValidUser;
use App\Http\Middleware\IsValidUser;
use App\Http\Middleware\NotLoggedIn;
use Illuminate\Foundation\Application;
use App\Http\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'CheckRole' => IsValidUser::class,
        ]);
        $middleware->appendToGroup('ok-user',[
            EnsureEmailIsVerified::class,
            NotLoggedIn::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
