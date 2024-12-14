<?php

namespace Modules\SharedCommon\Exceptions\CustomException;

enum ErrorType: string {
    case ERROR = "error";
    case WARN = "warn";
    case INFO = "info";
    case DEBUG = "debug";
}
