<?php

namespace Modules\User\Requests;

use Illuminate\Validation\Rule;
use Modules\SharedCommon\Requests\BaseRequest;

class AuthRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array {
        return [
            "email"    => ["required", "email", Rule::exists('users', 'email')],
            "password" => ["required", "string"],
        ];
    }
}
