<?php

namespace Modules\SharedCommon\Http\Authorization;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class GateWithAPIKey {
    public static function authorize(string $ability, mixed $arguments = []): Response|bool {
        $request = request()->request;

        if ($request->has("use_api_key") && $request->get("use_api_key", false)) {
            return true;
        }

        return Gate::authorize($ability, $arguments);
    }
}
