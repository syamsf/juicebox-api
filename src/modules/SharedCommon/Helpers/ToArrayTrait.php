<?php

namespace Modules\SharedCommon\Helpers;

trait ToArrayTrait {
    public function toArray(bool $isNull = true): array {
        $array = [];

        foreach ($this as $key => $value) {
            $key = TextUtil::convertCamelCaseIntoSnakeCase($key);

            if (!$isNull) {
                if (is_null($value))
                    continue;
            }

            $array[$key] = $value;
        }

        return $array;
    }

    public function isNotNull(array $variables): array {
        if (empty($variables))
            throw new \Exception("variables is required");

        $filtered = [];

        foreach ($variables as $key => $value) {
            if (is_null($value))
                continue;

            $filtered[$key] = $value;
        }

        return $filtered;
    }
}
