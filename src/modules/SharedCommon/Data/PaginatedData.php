<?php

namespace Modules\SharedCommon\Data;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\SharedCommon\Filters\Data\FilterData;

class PaginatedData {
    public function __construct(
        public readonly array $data = [],
        public readonly ?array $links = [],
        public readonly ?array $pagination = [],
    ) {
    }

    public static function make(
        array $data = [],
        ?array $links = [],
        ?array $pagination = [],
    ): self {
        return new self(
            data: $data,
            links: $links,
            pagination: $pagination
        );
    }

    public static function fromFilteredResult(FilterData $filteredResult, array $resultData = []): self {
        $result    = $filteredResult->result;
        $resultArr = $result->toArray();
        $links     = $resultArr['links'];

        unset($resultArr['links']);
        unset($resultArr['data']);

        return new self(
            data: empty($resultData) ? $result->all() : $resultData,
            links: $links,
            pagination: $resultArr
        );
    }
}
