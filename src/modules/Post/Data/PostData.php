<?php

namespace Modules\Post\Data;

use Modules\Post\Requests\CreatePostRequest;
use Modules\Post\Requests\UpdatePostRequest;
use Modules\User\Models\UserModel;

class PostData {
    public function __construct(
        public readonly string    $title,
        public readonly string    $content,
        public readonly UserModel $user,
    ) {
    }

    public static function fromRequest(CreatePostRequest|UpdatePostRequest $request): self {
        return new self(
            title: $request->input('title'),
            content: $request->input('content'),
            user: auth()->user(),
        );
    }

    public function format(): array {
        return [
            "title"   => $this->title,
            "content" => $this->content,
            "user_id" => $this->user->id,
        ];
    }
}
