<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\NoCache;
use App\Http\Middleware\PortalAuth;
use App\Http\Middleware\LoggedOutStateGuard;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->validateCsrfTokens(except: [
            'saml2/*/acs',
            'saml2/*/sls',
        ]);

        $middleware->alias([
            'portal.auth' => \App\Http\Middleware\EnsurePortalAuthenticated::class,
            'portal.appweb' => \App\Http\Middleware\EnsureAppWebGroup::class,
            'no.cache' => NoCache::class,
            'logout.guard' => LoggedOutStateGuard::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
