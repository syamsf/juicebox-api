<?php

namespace Modules\SharedCommon\Helpers;

class TextUtil {
    public static function convertCamelCaseIntoSnakeCase(string $input): string {
        $converted = preg_replace('/([a-z])([A-Z])/', '$1_$2', $input);

        return strtolower($converted);
    }

    public static function typeCast(string $dataType, ?string $value = null) {
        if (is_null($value))
            return $value;

        return match ($dataType) {
            'string' => $value,
            'int' => (int)$value,
            'bool' => (bool)$value,
            'float' => (float)$value,
            default => $value
        };
    }

    /**
     * @return void
     */
    public static function nullOrValue($value) {
        if (is_null($value))
            return null;

        if ($value == "null")
            return null;

        return $value;
    }

    public static function replacePlaceholder(array $keys, array $values, string $content): ?string {
        if (empty($content))
            return null;

        if (empty($keys) || empty($values))
            return $content;

        return str_replace($keys, $values, $content);
    }
}
