<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\SharedCommon\Exceptions\CustomException\NoReportException;
use Modules\SharedCommon\Exceptions\Handler\JsonExceptionHandler;
use Modules\SharedCommon\Http\Middleware\CustomAuthMechanism;
use Modules\SharedCommon\Http\Middleware\ForceJsonResponse;
use Modules\SharedCommon\Http\Middleware\HorizonAuth;
use Modules\SharedCommon\Http\Middleware\ValidateHeaderAuth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend([
            \Modules\CorrelationId\Middleware\LogHostnameContextMiddleware::class,
            \Modules\CorrelationId\Middleware\CorrelationIdMiddleware::class,
            \Modules\CorrelationId\Middleware\ClientRequestIdMiddleware::class,
            \Modules\CorrelationId\Middleware\LogContextMiddleware::class,
            \Modules\CorrelationId\Middleware\LogRequestPayloadDataMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function(NoReportException $e) {
            return false;
        });

        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                $exceptionResult = (new JsonExceptionHandler())->render($request, $e);

                if ($exceptionResult) {
                    return $exceptionResult;
                }
            }
        });
    })->create();
