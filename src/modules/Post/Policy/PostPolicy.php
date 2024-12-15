<?php

namespace Modules\Post\Policy;

use Modules\Post\Models\PostModel;
use Modules\User\Models\UserModel;

class PostPolicy {
    public function belongsToCurrentUser(UserModel $user, PostModel $model): bool {
        return ($user->id == $model->user_id);
    }
}
