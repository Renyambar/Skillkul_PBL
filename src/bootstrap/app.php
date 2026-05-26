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
    ->withMiddleware(function (Middleware $middleware): void {
        // Kecualikan endpoint webhook Midtrans dari CSRF verification.
        // Midtrans server melakukan POST ke URL ini secara langsung (tanpa token CSRF).
        $middleware->validateCsrfTokens(except: [
            'midtrans/notification',
        ]);

        // Daftarkan alias middleware untuk role-based access control.
        // Penggunaan di routes: ->middleware('role:freelancer') atau ->middleware('role:admin')
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
