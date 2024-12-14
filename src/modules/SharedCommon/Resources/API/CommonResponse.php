<?php

namespace Modules\SharedCommon\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\SharedCommon\Data\APIResponseData;


class CommonResponse extends ResourceCollection
{
    public function __construct($resource, private readonly APIResponseData $apiResponseData) {
        parent::__construct($resource);
    }


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): Collection
    {
        return $this->collection;
    }

    public function with(Request $request): array {
        return [
            'meta' => [
                'status_code'  => $this->apiResponseData->httpCode,
                'success'      => $this->apiResponseData->isSuccess,
                'message'      => $this->apiResponseData->message,
                'pagination'   => $this->apiResponseData->pagination,
            ],
            'links' => $this->apiResponseData->links,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void {
        $response->setStatusCode($this->apiResponseData->httpCode);
    }
}
