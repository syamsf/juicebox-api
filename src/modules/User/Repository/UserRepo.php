<?php declare(strict_types = 1);

namespace Modules\User\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\SharedCommon\Config\Status;
use Modules\User\Data\UserManagement\UserCreateData;
use Modules\User\Data\UserManagement\UserUpdateData;
use Modules\User\Models\UserModel;

class UserRepo {
    public function create(UserCreateData $data): UserModel {
        return UserModel::create($data->format());
    }

    public function isEmailExist(string $email): bool {
        return UserModel::where("email", $email)->exists();
    }

    public function update(int $id, array $data): void {
        UserModel::where("id", $id)->update($data);
    }

    public function updateByModel(UserModel $userModel, array $data): void {
        $userModel->update($data);
    }

    public function fetchById(int $id): ?UserModel {
        return UserModel::whereId($id)->with("roles:id,name,guard_name")->first();
    }

    public function fetchByEmail(string $email): ?UserModel {
        return UserModel::whereEmail($email)->first();
    }

    public function fetchSimpleUsersList(bool $activeOnly = true): Collection {
        $query = UserModel::select(["id", "name", "email"]);

        if ($activeOnly) {
            return $query->where("status", "=", Status::ENABLE->value)->get();
        }

        return $query->get();
    }

    public function updateByCurrentModel(UserUpdateData $data, UserModel $userModel): void {
        $userModel->update($data->format());
    }

    public function fetchAll(): Builder {
        return UserModel::query()->with("roles:id,name,guard_name");
    }
}
