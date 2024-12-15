<?php

namespace Modules\Weather\Controllers;

use Illuminate\Http\Request;
use Modules\SharedCommon\Helpers\ResponseFormatter\APIResponse;
use Modules\SharedCommon\Resources\API\CommonResponse;
use Modules\Weather\Action\WeatherDataFetcher;
use Modules\Weather\Data\WeatherRequestData;

class DataFetcherController {
    public function __construct(
        private readonly WeatherDataFetcher $weatherDataFetcher,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function fetchWeather(Request $request): CommonResponse {
        $city    = empty($request->query('city') ?? null) ? "perth" : $request->query('city');
        $adapter = config("weather.adapter");

        $response = $this->weatherDataFetcher->fetchCurrentWeather(WeatherRequestData::make($city), $adapter);
        return APIResponse::success($response->webResponse());
    }
}
