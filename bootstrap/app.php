<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\logSuspiciousRequests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(logSuspiciousRequests::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 404 (Web)
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if (!$request->expectsJson()) {
                return response()->view('errors.404', [], 404);
            }
        });
    })->create();
