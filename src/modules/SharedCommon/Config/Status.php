<?php

namespace Modules\SharedCommon\Config;

use Modules\SharedCommon\Traits\EnumTrait;

enum Status: string {
    use EnumTrait;

    case ENABLE = "ENABLE";
    case DISABLE = "DISABLE";
}
