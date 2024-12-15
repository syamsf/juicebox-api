<?php

namespace Modules\Post\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Modules\Post\Filters\Data\PostFilterData;
use Modules\Post\Filters\Filter\FilterByContent;
use Modules\Post\Filters\Filter\FilterByGlobalKeyword;
use Modules\Post\Filters\Filter\FilterByTitle;
use Modules\Post\Models\PostModel;
use Modules\Post\Repositories\PostRepo;
use Modules\SharedCommon\Data\PaginatedData;
use Modules\SharedCommon\Filters\Data\FilterData;
use Modules\SharedCommon\Filters\Filter\Ordering\SortBy;
use Modules\SharedCommon\Filters\Filter\Result\Result;

class DataFetcherAction {
    public function __construct(
        private readonly PostRepo $postRepo,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function fetchById(int $id, int $userId): PostModel {
        $result = $this->postRepo->fetchByIdAndUserId($id, $userId);
        if (empty($result)) {
            throw new \Exception('Post not found', 404);
        }

        return $result;
    }

    public function fetchAll(Request $request): PaginatedData {
        $query = $this->postRepo->fetchAll(auth()->user()->id);

        $filterData = FilterData::make(
            builder: $query,
            request: $request,
            filter: PostFilterData::fromRequest($request),
        );

        /** @var FilterData $filteredResult */
        $filteredResult = Pipeline::send($filterData)
            ->through([
                FilterByGlobalKeyword::class,
                FilterByTitle::class,
                FilterByContent::class,
                SortBy::class,
                Result::class
            ])->thenReturn();

        return PaginatedData::fromFilteredResult($filteredResult);
    }
}
