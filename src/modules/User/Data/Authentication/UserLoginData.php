<?php

namespace Modules\User\Data\Authentication;

use Modules\User\Requests\AuthRequest;

class UserLoginData {
    /**
     * @throws \Exception
     */
    public function __construct(
        public readonly string   $email,
        public readonly string   $password,
    ) {
        $this->validate();
    }

    /**
     * @throws \Exception
     */
    public static function fromLoginRequest(AuthRequest $authRequest): self {
        return new self(
            email: $authRequest->input('email'),
            password: $authRequest->input('password'),
        );
    }

    /**
     * @throws \Exception
     */
    public function validate(): void {
        if (empty($this->email)) {
            throw new \Exception("email cannot be empty");
        }

        if (empty($this->password)) {
            throw new \Exception("password cannot be empty");
        }
    }

    public function formatEmailPassword(): array {
        return [
            "email"     => $this->email,
            "password"  => $this->password,
        ];
    }
}
