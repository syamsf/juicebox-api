<?php

namespace Modules\SharedCommon\Http\Middleware;

use Modules\SharedCommon\Action\Authentication\HeaderAuth;
use Closure;
use Illuminate\Http\Request;

class ValidateHeaderAuth {
    public function __construct(
        private readonly HeaderAuth $headerAuth
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next, string $authType = "") {
        $this->headerAuth->auth($request, $authType);
        return $next($request);
    }
}
