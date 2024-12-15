<?php

namespace Modules\Post\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Post\Data\PostData;
use Modules\Post\Models\PostModel;

class PostRepo {
    public function create(PostData $data): PostModel {
        return PostModel::create($data->format());
    }

    public function fetchByIdAndUserId(int $id, int $userId): ?PostModel {
        return PostModel::where("id", $id)->where("user_id", $userId)->first();
    }

    public function fetchAll(int $userId): Builder {
        return PostModel::query()->where("user_id", $userId)->with(["user"]);
    }

    public function update(PostModel $post, array $data): void {
        $post->update($data);
    }

    public function delete(PostModel $post): void {
        $post->delete();
    }
}
