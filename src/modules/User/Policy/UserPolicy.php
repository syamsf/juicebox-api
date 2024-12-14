<?php

namespace Modules\User\Policy;

use Modules\User\Models\UserModel;

class UserPolicy {
    public function update(UserModel $user, UserModel $model): bool {
        return ($user->id == $model->id) || $user->hasRole("super_admin") || $user->hasRole("admin");
    }

    public function fetchById(UserModel $user, UserModel $model): bool {
        return ($user->id == $model->id) || $user->hasRole("super_admin") || $user->hasRole("admin");
    }

    public function adminOrSuperAdminOnly(UserModel $user): bool {
        return $user->hasRole("super_admin") || $user->hasRole("admin");
    }

    public function hasRoleUser(UserModel $user): bool {
        return $user->hasRole("user");
    }
}
