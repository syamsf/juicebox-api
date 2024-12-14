<?php

namespace Modules\User\Filters\Filter;

use Modules\SharedCommon\Filters\Data\FilterData;

class FilterByEmail {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $query = empty($filterData->filter->email)
            ? $filterData->builder
            : $filterData->builder->where("email", "LIKE", "%{$filterData->filter->email}%");

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
