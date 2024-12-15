<?php

namespace Modules\Weather\Action\Adapter;

use Illuminate\Support\Facades\Http;
use Modules\Weather\Data\CurrentWeatherResponseData;
use Modules\Weather\Data\WeatherErrorMessageData;
use Modules\Weather\Data\WeatherRequestData;

class WeatherApiAdapter implements WeatherAdapterContract {
    private WeatherErrorMessageData $errorMessages;

    public function __construct() {
        $this->errorMessages = WeatherErrorMessageData::notError();
    }

    public function getCurrentWeather(WeatherRequestData $requestData): ?CurrentWeatherResponseData {
        $apiKey   = config('weather.weatherapi_api_key');
        $city     = $requestData->city;
        $result   = Http::get("httpS://api.weatherapi.com/v1/current.json", ['key' => $apiKey, 'q' => $city]);
        $response = $result->json();

        if ($result->clientError()) {
            $this->errorMessages = WeatherErrorMessageData::error(
                message: $response["error"]["message"] ?? "Unknown error",
                code: $response["error"]["code"] ?? 400,
                httpCode: $result->getStatusCode()
            );

            return null;
        }

        return CurrentWeatherResponseData::make(
            currentWeather: $response["current"]["condition"]["text"]?? null,
            rawData: $response,
        );
    }

    public function getErrorMessages(): WeatherErrorMessageData {
        return $this->errorMessages;
    }
}
