<?php

namespace Modules\User\Filters\Filter;

use Modules\SharedCommon\Filters\Data\FilterData;

class FilterByGlobalKeyword {
    public function __invoke(FilterData $filterData, \Closure $next): FilterData {
        $allowedColumn = ["email", "name"];

        $keyword = $filterData->filter->globalFilterKeyword;
        $column  = empty($filterData->filter->globalFilterColumn) ? ["name"] : $filterData->filter->globalFilterColumn;
        $column  = array_intersect($column, $allowedColumn);

        if (empty($keyword) || empty($column)) {
            $query = $filterData->builder;
            return $next(FilterData::fromFilterClosure($query, $filterData));
        }

        $query   = $filterData->builder;

        $query->where(function ($innerQuery) use ($column, $keyword) {
            foreach ($column as $index => $item) {
                $innerQuery->{$index == 0 ? 'where' : 'orWhere'}("{$item}", "LIKE", "%{$keyword}%");
            }
        });

        return $next(FilterData::fromFilterClosure($query, $filterData));
    }
}
