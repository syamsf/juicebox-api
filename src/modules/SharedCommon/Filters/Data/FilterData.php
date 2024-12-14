<?php

namespace Modules\SharedCommon\Filters\Data;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\SharedCommon\Filters\Data\Default\DistinctByData;
use Modules\SharedCommon\Filters\Data\Default\GroupByData;
use Modules\SharedCommon\Filters\Data\Default\PerPageData;
use Modules\SharedCommon\Filters\Data\Default\SortByData;

class FilterData {
    public function __construct(
        public readonly Builder|QueryBuilder        $builder,
        public readonly Request                     $request,
        public readonly BaseFilter                  $filter,
        public readonly SortByData                  $orderByFilter,
        public readonly PerPageData                 $perPageFilter,
        public readonly GroupByData                 $groupByFilter,
        public readonly DistinctByData              $distinctByFilter,
        public Collection|LengthAwarePaginator|null $result = null
    ) {
    }

    public static function make(
        Builder|QueryBuilder $builder,
        Request              $request,
        BaseFilter           $filter,
        ?SortByData          $orderByFilter = null,
        ?PerPageData         $perPageFilter = null,
        ?GroupByData         $groupByFilter = null,
        ?DistinctByData      $distinctByFilter = null
    ): self {
        $orderByFilter    = empty($orderByFilter) ? SortByData::fromRequest($request) : $orderByFilter;
        $perPageFilter    = empty($perPageFilter) ? PerPageData::fromRequest($request) : $perPageFilter;
        $groupByFilter    = empty($groupByFilter) ? GroupByData::fromRequest($request) : $groupByFilter;
        $distinctByFilter = empty($distinctByFilter) ? DistinctByData::fromRequest($request) : $distinctByFilter;

        return new self(
            builder: $builder,
            request: $request,
            filter: $filter,
            orderByFilter: $orderByFilter,
            perPageFilter: $perPageFilter,
            groupByFilter: $groupByFilter,
            distinctByFilter: $distinctByFilter
        );
    }

    public static function fromFilterClosure(QueryBuilder|Builder $query, FilterData $filterData): self {
        return new self(
            builder: $query,
            request: $filterData->request,
            filter: $filterData->filter,
            orderByFilter: $filterData->orderByFilter,
            perPageFilter: $filterData->perPageFilter,
            groupByFilter: $filterData->groupByFilter,
            distinctByFilter: $filterData->distinctByFilter,
            result: $filterData->result
        );
    }

    public static function result(FilterData $filterData, Collection|LengthAwarePaginator|null $result): self {
        return new self(
            builder: $filterData->builder,
            request: $filterData->request,
            filter: $filterData->filter,
            orderByFilter: $filterData->orderByFilter,
            perPageFilter: $filterData->perPageFilter,
            groupByFilter: $filterData->groupByFilter,
            distinctByFilter: $filterData->distinctByFilter,
            result: $result
        );
    }
}
