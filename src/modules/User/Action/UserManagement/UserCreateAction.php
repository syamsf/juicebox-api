<?php declare(strict_types = 1);

namespace Modules\User\Action\UserManagement;

use Modules\User\Data\UserManagement\UserCreateData;
use Modules\User\Models\UserModel;
use Modules\User\Repository\UserRepo;

class UserCreateAction {
    public function __construct(
        private readonly UserRepo $userRepo,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function create(UserCreateData $data): UserModel {
        $userModel = $this->userRepo->fetchByEmail($data->email);
        if (!empty($userModel)) {
            throw new \Exception("User with email {$data->email} is already registered");
        }

        return $this->userRepo->create($data);
    }
}
