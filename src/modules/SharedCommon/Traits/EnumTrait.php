<?php

namespace Modules\SharedCommon\Traits;

trait EnumTrait {
    public static function getNames(): array {
        return array_column(self::cases(), 'name');
    }

    public static function getValues(): array {
        return array_column(self::cases(), 'value');
    }

    public static function getNameAndValue(): array {
        return array_combine(self::getNames(), self::getValues());
    }
}
