<?php

namespace Modules\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest {
    public function rules(): array {
        return [
            "title"   => ["required", "string"],
            "content" => ["required", "string"],
        ];
    }
}
