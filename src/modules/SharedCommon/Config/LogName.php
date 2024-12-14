<?php

namespace Modules\SharedCommon\Config;

enum LogName: string {
    case AUTHENTICATION = "AUTHENTICATION";
    case ROLE = "ROLE";
    case USER_MANAGEMENT = "USER_MANAGEMENT";
    case REMINDER = "REMINDER";
    case REPORT = "REPORT";
}
