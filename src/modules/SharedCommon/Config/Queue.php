<?php

namespace Modules\SharedCommon\Config;

use Modules\SharedCommon\Traits\EnumTrait;

enum Queue: string {
    use EnumTrait;

    case DEFAULT = "default";
    case EMAIL_SENDING = "email-sending";
    case LOGS = "logs";
    case NOTIFICATION = "notification";
    case TEST_NOTIFICATION = "test-notification";
}
