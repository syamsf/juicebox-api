<?php

namespace Modules\Weather\Action\Adapter;

use Illuminate\Support\Facades\Http;
use Modules\Weather\Data\CurrentWeatherResponseData;
use Modules\Weather\Data\WeatherErrorMessageData;
use Modules\Weather\Data\WeatherRequestData;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

class OpenWeatherMapAdapter implements WeatherAdapterContract {
    private WeatherErrorMessageData $errorMessages;

    public function __construct() {
        $this->errorMessages = WeatherErrorMessageData::notError();
    }

    /**
     * @throws \Exception
     */
    public function getCurrentWeather(WeatherRequestData $requestData): ?CurrentWeatherResponseData {
        $apiKey   = config('weather.open_weather_map_api_key');
        $city     = $requestData->city;
        $result   = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}");
        $response = $result->json();

        if ($result->clientError()) {
            $this->errorMessages = WeatherErrorMessageData::error(
                message: $response["message"] ?? "Unknown error",
                code: $response["cod"] ?? 400,
                httpCode: $result->getStatusCode()
            );

            return null;
        }

        return CurrentWeatherResponseData::make(
            currentWeather: $response['weather'][0]['description'] ?? null,
            rawData: $response,
        );
    }

    public function getErrorMessages(): WeatherErrorMessageData {
        return $this->errorMessages;
    }
}
