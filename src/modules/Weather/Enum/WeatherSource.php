<?php

namespace Modules\Weather\Enum;

enum WeatherSource: string {
    case DEFAULT = "DEFAULT";
    case OPEN_WEATHER_MAP = "OPEN_WEATHER_MAP";
    case WEATHER_API = "WEATHER_API";
}
