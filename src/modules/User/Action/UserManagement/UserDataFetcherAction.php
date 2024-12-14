<?php declare(strict_types = 1);

namespace Modules\User\Action\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Modules\SharedCommon\Data\PaginatedData;
use Modules\SharedCommon\Filters\Data\FilterData;
use Modules\SharedCommon\Filters\Filter\Ordering\SortBy;
use Modules\SharedCommon\Filters\Filter\Result\Result;
use Modules\User\Data\UsersResponseData;
use Modules\User\Filters\Data\UsersFilterData;
use Modules\User\Filters\Filter\FilterByEmail;
use Modules\User\Filters\Filter\FilterByGlobalKeyword;
use Modules\User\Filters\Filter\FilterByName;
use Modules\User\Models\UserModel;
use Modules\User\Repository\UserRepo;

class UserDataFetcherAction {
    public function __construct(
        private readonly UserRepo $userRepo
    ) {
    }

    public function fetchAll(Request $request): PaginatedData {
        $query = $this->userRepo->fetchAll();

        $filterData = FilterData::make(
            builder: $query,
            request: $request,
            filter: UsersFilterData::fromRequest($request),
        );

        /** @var FilterData $filteredResult */
        $filteredResult = Pipeline::send($filterData)
            ->through([
                FilterByGlobalKeyword::class,
                FilterByName::class,
                FilterByEmail::class,
                SortBy::class,
                Result::class
            ])->thenReturn();

        $webResult = [];
        foreach ($filteredResult->result->all() as $item) {
            $webResult[] = UsersResponseData::fromUserModel($item)->format();
        }

        return PaginatedData::fromFilteredResult($filteredResult, $webResult);
    }

    /**
     * @throws \Exception
     */
    public function fetchById(int $userId): UserModel {
        if (empty($userId))
            throw new \Exception("user_id is required");

        $data = $this->userRepo->fetchById($userId);
        if (empty($data))
            throw new \Exception("user with id {$userId} is not found", 404);

        return $data;
    }
}
