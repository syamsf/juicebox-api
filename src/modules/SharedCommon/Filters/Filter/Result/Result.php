<?php

namespace Modules\SharedCommon\Filters\Filter\Result;

use Modules\SharedCommon\Filters\Data\FilterData;

class Result {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        if (!is_null($filterData->result))
            return $filterData;

        $result = empty($filterData->perPageFilter->perPage)
            ? $filterData->builder->get()
            : $filterData->builder->paginate($filterData->perPageFilter->perPage)->withQueryString();

        $filterData->result = $result;

        return $filterData;
    }
}
