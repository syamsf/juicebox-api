<?php

namespace Modules\Weather\Action\Adapter;

use Modules\Weather\Data\CurrentWeatherResponseData;
use Modules\Weather\Data\WeatherErrorMessageData;
use Modules\Weather\Data\WeatherRequestData;

interface WeatherAdapterContract {
    public function getCurrentWeather(WeatherRequestData $requestData): ?CurrentWeatherResponseData;
    public function getErrorMessages(): WeatherErrorMessageData;
}
