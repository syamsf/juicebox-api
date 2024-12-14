<?php

namespace Modules\SharedCommon\Config;

use Modules\SharedCommon\Traits\EnumTrait;

enum Choice: string {
    use EnumTrait;

    case YES = 'YES';
    case NO = 'NO';
}
