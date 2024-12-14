<?php

namespace Modules\SharedCommon\Http\Middleware;

use Closure;

class HorizonAuth {
    public function handle($request, Closure $next) {
        $user = config('horizon.horizon_user');
        $pass = config('horizon.horizon_pass');

        if ($request->getUser() !== $user || $request->getPassword() !== $pass) {
            return response('Unauthorized', 401, ['WWW-Authenticate' => 'Basic']);
        }

        return $next($request);
    }
}
