<?php

namespace Modules\User\Requests\User;

use Modules\SharedCommon\Requests\BaseRequest;

class UserUpdateRequest extends BaseRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            "name"     => ["required", "string", "min:5", "max:255"],
            "email"    => ["required", "email"],
            "password" => ["sometimes", "string", "nullable"],
        ];
    }
}
