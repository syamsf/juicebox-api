<?php

namespace Modules\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest {
    public function rules(): array {
        return [
            "title"   => ["required", "string"],
            "content" => ["required", "string"],
        ];
    }
}
