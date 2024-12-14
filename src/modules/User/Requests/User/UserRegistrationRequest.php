<?php

namespace Modules\User\Requests\User;

use Modules\SharedCommon\Requests\BaseRequest;

class UserRegistrationRequest extends BaseRequest
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
    public function rules(): array
    {
        return [
            "name"        => "required|string|min:5|max:255",
            "email"       => "required|email|unique:users,email",
            "password"    => "required|string|min:8|confirmed",
        ];
    }
}
