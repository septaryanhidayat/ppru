<?php

use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\EnsureUnitAccess;
use App\Http\Middleware\IncrementVisitorCounter;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SecurityMonitorMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'unit.access' => EnsureUnitAccess::class,
        ]);
        $middleware->web(append: [
            CheckMaintenanceMode::class,
            IncrementVisitorCounter::class,
            SecurityHeaders::class,
            SecurityMonitorMiddleware::class,
        ]);
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            $maxPost = ini_get('post_max_size') ?: '8M';
            $message = "Ukuran total berkas yang Anda unggah terlalu besar (melebihi batas server {$maxPost}). Silakan gunakan berkas gambar dengan ukuran lebih ringkas atau naikkan post_max_size di cPanel.";

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 413);
            }

            return back()->with('error', $message);
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
