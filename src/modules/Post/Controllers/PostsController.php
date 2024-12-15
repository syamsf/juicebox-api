<?php

namespace Modules\Post\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Post\Action\DataFetcherAction;
use Modules\Post\Action\PostProvisioningAction;
use Modules\Post\Data\PostData;
use Modules\Post\Requests\CreatePostRequest;
use Modules\Post\Requests\UpdatePostRequest;
use Modules\SharedCommon\Helpers\ResponseFormatter\APIResponse;
use Modules\SharedCommon\Resources\API\CommonResponse;

class PostsController {
    public function __construct(
        private readonly DataFetcherAction $dataFetcherAction,
        private readonly PostProvisioningAction $postProvisioningAction,
    ) {
    }

    public function fetchAll(Request $request): CommonResponse {
        $result = $this->dataFetcherAction->fetchAll($request);

        return APIResponse::successWithPagination($result);
    }

    /**
     * @throws \Exception
     */
    public function fetchById(int $id): CommonResponse {
        $postModel = $this->dataFetcherAction->fetchById($id, auth()->user()->id);

        return APIResponse::success($postModel->toArray());
    }

    public function create(CreatePostRequest $request): CommonResponse {
        $data   = PostData::fromRequest($request);
        $result = $this->postProvisioningAction->create($data);

        return APIResponse::success($result->toArray());
    }

    /**
     * @throws \Exception
     */
    public function update(UpdatePostRequest $request, int $id): CommonResponse {
        $postModel = $this->dataFetcherAction->fetchById($id, auth()->user()->id);
        $data      = PostData::fromRequest($request);

        Gate::authorize("belongsToCurrentUser", $postModel);

        $result = $this->postProvisioningAction->update($postModel, $data);

        return APIResponse::success($result->toArray());
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id): CommonResponse {
        $postModel = $this->dataFetcherAction->fetchById($id, auth()->user()->id);

        $this->postProvisioningAction->delete($postModel);

        return APIResponse::success(["message" => "Post deleted successfully"]);
    }
}
