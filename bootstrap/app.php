<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',

        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/perangkat.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            'set.tenant.context' => \App\Http\Middleware\SetTenantContext::class,
            'auth.kecamatan' => \App\Http\Middleware\AuthorizeKecamatanAdmin::class,

            'auth.perangkat_daerah' => \App\Http\Middleware\AuthorizePerangkatDaerahAdmin::class,

            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'clear.tenant.context' => \App\Http\Middleware\ClearTenantContext::class,
            'block.kabupaten.slug' => \App\Http\Middleware\BlockKabupatenSlug::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();
