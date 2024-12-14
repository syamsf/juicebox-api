<?php

namespace Modules\User\Filters\Filter;

use Modules\SharedCommon\Filters\Data\FilterData;

class FilterByName {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $query = empty($filterData->filter->name)
            ? $filterData->builder
            : $filterData->builder->where("name", "LIKE", "%{$filterData->filter->name}%");

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
