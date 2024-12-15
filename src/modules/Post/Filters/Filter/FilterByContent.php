<?php

namespace Modules\Post\Filters\Filter;

use Modules\SharedCommon\Filters\Data\FilterData;

class FilterByContent {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $query = empty($filterData->filter->content)
            ? $filterData->builder
            : $filterData->builder->where("content", "LIKE", "%{$filterData->filter->content}%");

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
