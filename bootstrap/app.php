<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan SetLocale agar berjalan otomatis di setiap request web
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
            // Diperbaiki dari EnsureOrganizerIsVerified menjadi EnsureOrganizerVerified
            'organizer.verified' => \App\Http\Middleware\EnsureOrganizerVerified::class,
        ]);

        $middleware->redirectGuestsTo(fn (Request $request) =>
            $request->is('organizer/*') ? route('organizer.login') : route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();