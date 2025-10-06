<?php

use App\Http\Middleware\CustomRequirePassword;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$customEnvPath = __DIR__.'/../../.env';
if (file_exists($customEnvPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable($customEnvPath, '.env');
    $dotenv->load();
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'password.confirm' => CustomRequirePassword::class,
            'jwt' => JwtMiddleware::class
        ]);
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
