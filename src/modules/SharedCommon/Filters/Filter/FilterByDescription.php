<?php

namespace Modules\SharedCommon\Filters\Filter;

use Modules\SharedCommon\Filters\Data\FilterData;

class FilterByDescription {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $query = empty($filterData->filter->description)
            ? $filterData->builder
            : $filterData->builder->where("description", "LIKE", "%{$filterData->filter->description}%");

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
