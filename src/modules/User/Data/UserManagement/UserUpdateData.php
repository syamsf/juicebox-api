<?php

namespace Modules\User\Data\UserManagement;

use Illuminate\Support\Facades\Hash;
use Modules\SharedCommon\Helpers\TextUtil;
use Modules\User\Requests\User\UserUpdateRequest;

class UserUpdateData {
    public function __construct(
        public readonly int     $userId,
        public readonly string  $name,
        public readonly string  $email,
        public readonly ?string $password = null,
    ) {
    }

    public static function fromUserRequest(int $userId, UserUpdateRequest $request): self {
        $password = TextUtil::nullOrValue($request->input("password"));
        if (!empty($password)) {
            $request->validate(["password" => "min:8" , ["password" => $password]]);
        }

        return new self(
            userId: $userId,
            name: $request->input("name"),
            email: $request->input("email"),
            password: $password,
        );
    }

    public function format(): array {
        $data = [
            "name"   => $this->name,
            "email"  => $this->email,
        ];

        if (!empty($this->password)) {
            $data["password"] = Hash::make($this->password);
        }

        return $data;
    }
}
