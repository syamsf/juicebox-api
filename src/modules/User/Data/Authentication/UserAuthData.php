<?php

namespace Modules\User\Data\Authentication;

use Modules\User\Models\UserModel;

class UserAuthData {
    public function __construct(
        public readonly UserModel $userModel,
        public readonly string    $token,
        public readonly int       $expiresIn,
        public readonly bool      $isRefreshToken = false
    ) {
    }

    public static function make(
        UserModel $userModel,
        string    $token,
        int       $expiresIn,
        bool      $isRefreshToken = false
    ): self {
        return new self(
            userModel: $userModel,
            token: $token,
            expiresIn: $expiresIn,
            isRefreshToken: $isRefreshToken
        );
    }

    public function format(): array {
        return [
            "email"            => $this->userModel->email,
            "access_token"     => $this->token,
            "token_type"       => "bearer",
            "expires_in"       => $this->expiresIn,
            "is_refresh_token" => $this->isRefreshToken,
            "detail" => [
                "id"     => $this->userModel->id,
                "name"   => $this->userModel->name,
                "email"  => $this->userModel->email,
            ]
        ];
    }
}
