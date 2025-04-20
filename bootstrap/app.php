<?php

use App\Http\Middleware\IsLogin;
use App\Http\Middleware\PrometheusMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isLogin' => IsLogin::class,
        ]);

        $middleware->append(PrometheusMiddleware::class); // Tambahkan di sini saja
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
