<?php

namespace Modules\User\Action\Authentication;

use Illuminate\Http\Request;
use Modules\User\Data\Authentication\UserAuthData;
use Tymon\JWTAuth\JWT;

class RefreshTokenAction {
    public function __construct(
        private readonly JWT $jwt
    ) {
    }

    public function handle(Request $request): UserAuthData {
        $token     = auth()->refresh();
        $user      = auth()->user();
        $expiresIn = auth()->factory()->getTTL() * 60;

        $this->jwt->setToken($this->jwt->getToken()->get());
        $this->jwt->invalidate(true);

        return UserAuthData::make($user, $token, $expiresIn, isRefreshToken: true);
    }
}
