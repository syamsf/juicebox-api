<?php

namespace Modules\SharedCommon\Action\Authentication;

use Illuminate\Http\Request;

class HeaderAuth {
    /**
     * @throws \Exception
     */
    public function auth(Request $request, string $type = ""): void {
        $this->defaultHeaderAuth($request);
    }

    /**
     * @throws \Exception
     */
    public function defaultHeaderAuth(Request $request): void {
        $auth = $request->header('X-CUSTOM-AUTH');
        if (empty($auth))
            throw new \Exception("auth_key is required");

        $currentHeaderAuth = config('auth.header.default');

        if ($auth != $currentHeaderAuth)
            throw new \Exception("Unauthorized Header Authentication", 401);
    }
}
