<?php

namespace Modules\Post\Action;

use Modules\Post\Data\PostData;
use Modules\Post\Models\PostModel;
use Modules\Post\Repositories\PostRepo;

class PostProvisioningAction {
    public function __construct(
        private readonly PostRepo $postRepo,
    ) {
    }

    public function create(PostData $postData): PostModel {
        return $this->postRepo->create($postData);
    }

    public function update(PostModel $postModel, PostData $postData): PostModel {
        $this->postRepo->update($postModel, $postData->format());

        return $postModel->refresh();
    }

    public function delete(PostModel $postModel): void {
        $this->postRepo->delete($postModel);
    }
}
