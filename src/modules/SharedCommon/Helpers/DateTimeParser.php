<?php

namespace Modules\SharedCommon\Helpers;

use Carbon\Carbon;

class DateTimeParser {
    public static function fromString(?string $date): ?Carbon {
        if (empty($date))
            return null;

        return Carbon::parse($date);
    }
}
