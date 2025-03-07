<?php

use App\Http\Middleware\AlwaysAcceptJsonMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api.php'));
            Route::prefix('admin')
                ->middleware('web')
                ->group(base_path('routes/admin.php'));
            Route::prefix('my-zone')
                ->middleware('web')
                ->group(base_path('routes/my-zone.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: \App\Http\Middleware\setLocaleMiddleware::class);
        $middleware->statefulApi();
        $middleware->prependToGroup('api', AlwaysAcceptJsonMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Object Not Found'], 404);
            }
        });
    })->create();


