<?php

namespace Modules\User\Data\UserManagement;

use Modules\User\Requests\User\UserRegistrationRequest;

class UserCreateData {
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    public static function fromUserRequest(UserRegistrationRequest $request): self {
        return new self(
            name: $request->input("name"),
            email: $request->input("email"),
            password: $request->input("password"),
        );
    }

    public function format(): array {
        return [
            "name"     => $this->name,
            "email"    => $this->email,
            "password" => $this->password,
        ];
    }
}
