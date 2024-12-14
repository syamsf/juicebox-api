<?php declare(strict_types=1);

namespace Modules\User\Action\UserManagement;

use Modules\SharedCommon\Exceptions\CustomException\ExceptionFactory;
use Modules\User\Data\UserManagement\UserUpdateData;
use Modules\User\Models\UserModel;
use Modules\User\Repository\UserRepo;

class UserUpdateAction {
    public function __construct(
        private readonly UserRepo $userRepo,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function updateUserData(UserUpdateData $data): UserModel {
        $user = $this->fetchUserById($data->userId);

        $this->userRepo->update($data->userId, $data->format());

        // Validate email
        if ($user->email != $data->email) {
            $otherUsersData = $this->userRepo->fetchByEmail($data->email);
            if ($otherUsersData) {
                throw ExceptionFactory::error("Email is already registered, please try another email");
            }
        }

        return $this->userRepo->fetchById($data->userId);
    }

    /**
     * @throws \Throwable
     */
    private function fetchUserById(int $userId): UserModel {
        $user = $this->userRepo->fetchById($userId);
        if (empty($user))
            throw ExceptionFactory::error("User with ID {$userId} is not found", 404);

        return $user;
    }
}
