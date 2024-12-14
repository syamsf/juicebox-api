<?php

namespace Modules\SharedCommon\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Modules\SharedCommon\Action\Authentication\HeaderAuth;

class CustomAuthMechanism {
    public function __construct(
        private readonly HeaderAuth $headerAuth
    ) {

    }
    /**
     * @throws \Exception
     */
    public function handle(Request $request, \Closure $next, string $headerAuthType = "") {
        $isBearerTokenExist  = $request->hasHeader("Authorization");
        $authGuardMiddleware = app()->make(Authenticate::class);
        $exception           = null;

        // 1. Check first using JWT
        try {
            return $authGuardMiddleware->handle($request, $next, "api");
        } catch (\Exception $e) {
            $exception = $e;
        }

        // 2. Second check using header auth
        try {
            $this->headerAuth->auth($request, $headerAuthType);
        } catch (\Exception $e) {
            if ($isBearerTokenExist) {
                throw $exception;
            }

            throw $e;
        }

        return $next($request);
    }
}
