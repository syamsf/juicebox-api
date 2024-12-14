<?php

namespace Modules\SharedCommon\Filters\Filter\Ordering;

use Modules\SharedCommon\Filters\Data\FilterData;

class SortBy {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $query = empty($filterData->orderByFilter->key)
            ? $filterData->builder
            : $filterData->builder->orderBy($filterData->orderByFilter->key, $filterData->orderByFilter->direction->value);

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
