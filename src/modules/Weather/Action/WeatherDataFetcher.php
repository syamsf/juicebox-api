<?php

namespace Modules\Weather\Action;

use Illuminate\Support\Facades\Cache;
use Modules\Weather\Data\CurrentWeatherResponseData;
use Modules\Weather\Data\WeatherRequestData;

class WeatherDataFetcher {
    public function __construct(
        private readonly WeatherAdapter $weatherAdapter,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function fetchCurrentWeather(WeatherRequestData $requestData, string $adapter): CurrentWeatherResponseData {
        $adapter = $this->weatherAdapter->getCurrentAdapter($adapter);

        $ttlIn15Minutes = 15 * 60;

        return Cache::remember("weather_{$requestData->city}", $ttlIn15Minutes, function () use ($requestData, $adapter) {
            $result  = $adapter->getCurrentWeather($requestData);

            if ($adapter->getErrorMessages()->isError) {
                throw new \Exception(
                    "Failed to fetch weather data. Error: {$adapter->getErrorMessages()->message}",
                    $adapter->getErrorMessages()->httpCode ?? 400
                );
            }

            return $result;
        });
    }
}
