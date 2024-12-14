<?php

namespace Modules\User\Action\Authentication;

use Modules\SharedCommon\Exceptions\CustomException\ExceptionFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class ValidateTokenAction {
    public function __construct(
        private readonly JWT $jwt,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function handle(): array {
        try {
            $this->jwt->parseToken()->checkOrFail();

            $guard    = $this->jwt->payload()->get('guard');
            $userData = auth()->guard($guard)->user()->toArray();

            return [
                'is_token_valid' => true,
                'user' => array_merge(
                    $userData,
                    ["roles" => auth()->user()->getRoleNames()->toArray()],
                    ["permissions" => auth()->user()->getPermissionsViaRoles()->pluck("name")->toArray()]
                ),
            ];
        } catch (JWTException $e) {
            throw ExceptionFactory::jwtException($e->getMessage(), 400);
        } catch (\Exception $e) {
            throw new \Exception("Validate token exception: {$e->getMessage()}");
        }
    }
}
