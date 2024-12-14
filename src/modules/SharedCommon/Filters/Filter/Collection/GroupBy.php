<?php

namespace Modules\SharedCommon\Filters\Filter\Collection;

use Modules\SharedCommon\Filters\Data\FilterData;

class GroupBy {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        if (empty($filterData->groupByFilter->key))
            return $next(FilterData::fromFilterClosure($filterData->builder, $filterData));

        $tempResult = is_null($filterData->result) || $filterData->result->isEmpty()
            ? $filterData->builder->get()
            : $filterData->result;

        $tempResult = $tempResult->groupBy($filterData->groupByFilter->key);

        return $next(FilterData::result($filterData, $tempResult));
    }
}
