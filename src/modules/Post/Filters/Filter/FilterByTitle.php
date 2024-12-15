<?php

namespace Modules\Post\Filters\Filter;

use Modules\SharedCommon\Filters\Data\FilterData;

class FilterByTitle {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $query = empty($filterData->filter->title)
            ? $filterData->builder
            : $filterData->builder->where("title", "LIKE", "%{$filterData->filter->title}%");

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
