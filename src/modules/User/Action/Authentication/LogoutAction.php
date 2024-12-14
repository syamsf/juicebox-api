<?php

namespace Modules\User\Action\Authentication;

use Modules\User\Models\UserModel;
use Modules\User\Repository\UserRepo;

class LogoutAction {
    public function __construct(
        private readonly UserRepo $userRepo,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(): ?UserModel {
        $userId = auth()->payload()->get('sub');
        if (empty($userId))
            return null;

        auth()->invalidate(true);
        auth()->logout();

        $user = $this->userRepo->fetchById($userId);
        if (empty($user))
            throw new \Exception("user with id {$userId} is not found");

        return $user;
    }
}
