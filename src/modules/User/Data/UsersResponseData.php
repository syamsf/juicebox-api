<?php

namespace Modules\User\Data;

use Carbon\Carbon;
use Modules\User\Models\UserModel;

class UsersResponseData {
    public function __construct(
        public readonly int     $id,
        public readonly string  $name,
        public readonly string  $email,
        public readonly array   $roles = [],
        public readonly ?Carbon $createdAt = null,
        public readonly ?Carbon $updatedAt = null,
    ) {
    }

    public static function fromUserModel(UserModel $userModel): self {
        $roles = empty($userModel->roles) ? [] : $userModel->roles->map(fn ($item) => $item->name)->toArray();

        return new self(
            id: $userModel->id,
            name: $userModel->name,
            email: $userModel->email,
            roles: $roles,
            createdAt: Carbon::parse($userModel->created_at),
            updatedAt: Carbon::parse($userModel->updated_at),
        );
    }

    public function format(): array {
        return [
            "id"         => $this->id,
            "name"       => $this->name,
            "email"      => $this->email,
            "roles"      => $this->roles,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }
}
