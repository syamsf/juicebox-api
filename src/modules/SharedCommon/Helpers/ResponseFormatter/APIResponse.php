<?php

namespace Modules\SharedCommon\Helpers\ResponseFormatter;

use Modules\SharedCommon\Data\APIResponseData;
use Modules\SharedCommon\Data\PaginatedData;
use Modules\SharedCommon\Resources\API\CommonResponse;

class APIResponse {
    public static function success(
        mixed $resource = [],
        ?APIResponseData $apiResponseDto = null
    ): CommonResponse {
        $apiResponseDto = is_null($apiResponseDto) ? APIResponseData::success() : $apiResponseDto;
        return new CommonResponse($resource, $apiResponseDto);
    }

    public static function failed(
        mixed $resource = [],
        ?APIResponseData $apiResponseDto = null
    ): CommonResponse {
        $apiResponseDto = is_null($apiResponseDto) ? APIResponseData::failed() : $apiResponseDto;
        return new CommonResponse($resource, $apiResponseDto);
    }

    public static function successWithPagination(PaginatedData $data): CommonResponse {
        $apiResponseData = APIResponseData::success(
            links: $data->links,
            pagination: $data->pagination,
        );

        return new CommonResponse($data->data, $apiResponseData);
    }
}
