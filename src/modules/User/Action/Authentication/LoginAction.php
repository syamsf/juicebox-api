<?php

namespace Modules\User\Action\Authentication;

use Illuminate\Support\Facades\Auth;
use Modules\SharedCommon\Exceptions\CustomException\ExceptionFactory;
use Modules\User\Data\Authentication\UserAuthData;
use Modules\User\Data\Authentication\UserLoginData;

class LoginAction {
    /**
     * @throws \Throwable
     */
    public function handle(UserLoginData $userLoginData): UserAuthData {
        $credentials = $userLoginData->formatEmailPassword();

        $result = Auth::once($credentials);
        if (!$result) {
            throw ExceptionFactory::authException("Failed to login using email {$userLoginData->email}");
        }

        $userData  = auth()->user();
        $token     = auth()->attempt($credentials);
        $expiresIn = auth()->factory()->getTTL() * 60;

        return UserAuthData::make($userData, $token, $expiresIn);
    }
}
