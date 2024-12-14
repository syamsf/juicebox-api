<?php

namespace Modules\SharedCommon\Filters\Filter\Collection;

use Modules\SharedCommon\Filters\Data\FilterData;

class DistinctBy {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        if (empty($filterData->distinctByFilter->key))
            return $next(FilterData::fromFilterClosure($filterData->builder, $filterData));

        $tempResult = is_null($filterData->result) || $filterData->result->isEmpty()
            ? $filterData->builder->get()
            : $filterData->result;

        $tempResult = $tempResult->unique($filterData->distinctByFilter->key)->values();

        return $next(FilterData::result($filterData, $tempResult));
    }
}
