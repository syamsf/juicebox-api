<?php

namespace Modules\SharedCommon\Filters\Filter;

use Modules\SharedCommon\Filters\Data\FilterData;

class FilterById {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $query = empty($filterData->filter->id)
            ? $filterData->builder
            : $filterData->builder->where("id", "=", $filterData->filter->id);

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
