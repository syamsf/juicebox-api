<?php

namespace Modules\SharedCommon\Filters\Data;

use Modules\SharedCommon\Filters\Data\Default\PerPageData;
use Modules\SharedCommon\Filters\Data\Default\SortByData;

class FilterDataActivityLog {
    public function getParameterForLogging(FilterData $filterData): array {
        $filterParameter  = $this->getParameterFromFilter($filterData->filter);
        $sortByParameter  = $this->getParameterFromSortBy($filterData->orderByFilter);
        $perPageParameter = $this->getParameterFromPerPage($filterData->perPageFilter);

        return array_merge($filterParameter, $sortByParameter, $perPageParameter);
    }

    public function getParameterFromFilter(BaseFilter $filter): array {
        $parameter = get_object_vars($filter);
        $formattedParameter = [];

        foreach ($parameter as $key => $value) {
            if (!is_null($value)) {
                $formattedParameter[$key] = $value;
            }
        }

        return $formattedParameter;
    }

    public function getParameterFromSortBy(SortByData $sortByData): array {
        $formattedParameter = [];

        foreach (get_object_vars($sortByData) as $key => $value) {
            if ($key == "key" && empty($value))
                break;

            if (!is_null($value)) {
                $key = $this->fetchKeyName($key);
                $formattedParameter[$key] = $value;
            }
        }

        return $formattedParameter;
    }

    public function getParameterFromPerPage(PerPageData $perPageData): array {
        $formattedParameter = [];

        foreach (get_object_vars($perPageData) as $key => $value) {
            if (!is_null($value)) {
                $formattedParameter[$key] = $value;
            }
        }

        return $formattedParameter;
    }

    public function fetchKeyName(string $key): string {
        if ($key == "key")
            return "sortByKey";

        if ($key == "direction")
            return "sortByDirection";

        return $key;
    }
}
