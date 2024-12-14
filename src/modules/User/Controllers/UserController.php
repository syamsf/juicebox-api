<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\User\Action\Authentication\LoginAction;
use Modules\User\Action\Authentication\LogoutAction;
use Modules\User\Action\Authentication\RefreshTokenAction;
use Modules\User\Action\Authentication\ValidateTokenAction;
use Modules\User\Data\Authentication\UserLoginData;
use Modules\User\Requests\AuthRequest;
use Modules\User\Requests\User\UserRegistrationRequest;
use Modules\SharedCommon\Helpers\ResponseFormatter\APIResponse;
use Modules\SharedCommon\Resources\API\CommonResponse;
use Modules\User\Action\UserManagement\UserCreateAction;
use Modules\User\Action\UserManagement\UserDataFetcherAction;
use Modules\User\Action\UserManagement\UserUpdateAction;
use Modules\User\Data\UserManagement\UserCreateData;
use Modules\User\Data\UserManagement\UserUpdateData;
use Modules\User\Models\UserModel;
use Modules\User\Requests\User\UserUpdateRequest;

class UserController extends Controller {
    public function __construct(
        private readonly UserDataFetcherAction $userDataFetchAction,
        private readonly UserCreateAction      $userCreateAction,
        private readonly UserUpdateAction      $userUpdateAction,
        private readonly LoginAction           $loginAction,
        private readonly LogoutAction          $logoutAction,
        private readonly RefreshTokenAction    $refreshTokenAction,
        private readonly ValidateTokenAction   $validateTokenAction,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function update(int $userId, UserUpdateRequest $request): CommonResponse {
        Gate::authorize("update", UserModel::find($userId));

        $data   = UserUpdateData::fromUserRequest($userId, $request);
        $result = $this->userUpdateAction->updateUserData($data);

        return APIResponse::success($result->toArray());
    }

    /**
     * @throws \Throwable
     */
    public function createUser(UserRegistrationRequest $request): CommonResponse {
        $data   = UserCreateData::fromUserRequest($request);
        $result = $this->userCreateAction->create($data);

        return APIResponse::success($result->toArray());
    }

    /**
     * @throws \Exception
     */
    public function fetchById(int $userId): CommonResponse {
        $existingUser = $this->userDataFetchAction->fetchById($userId);
        Gate::authorize("fetchById", $existingUser);

        $result = $this->userDataFetchAction->fetchById($userId);

        return APIResponse::success($result->toArray());
    }

    /**
     * @throws \Throwable
     */
    public function login(AuthRequest $request): CommonResponse {
        $userLoginData = UserLoginData::fromLoginRequest($request);
        $result = $this->loginAction->handle($userLoginData);

        return APIResponse::success($result->format());
    }

    /**
     * @throws \Exception
     */
    public function logout(): CommonResponse {
        $result = $this->logoutAction->handle();
        if (empty($result)) {
            return APIResponse::success(["success" => true, "message" => "User is not found"]);
        }

        return APIResponse::success(["message" => "user logged out successfully", "email" => $result->email]);
    }

    public function refreshToken(Request $request): CommonResponse {
        $result = $this->refreshTokenAction->handle($request);
        return APIResponse::success($result->format());
    }

    /**
     * @throws \Throwable
     */
    public function validateToken(): CommonResponse {
        $result = $this->validateTokenAction->handle();
        return APIResponse::success($result);
    }
}
