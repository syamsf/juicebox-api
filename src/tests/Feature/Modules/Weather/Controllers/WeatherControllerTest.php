<?php

namespace Feature\Modules\Weather\Controllers;

use Modules\Weather\Action\WeatherDataFetcher;
use Modules\Weather\Data\WeatherRequestData;
use Tests\TestCase;
use Mockery;

class WeatherControllerTest extends TestCase {
    public function testFetchWeatherReturnsWeatherForGivenCity() {
        $mockWeatherDataFetcher = Mockery::mock(WeatherDataFetcher::class);

        $mockWeatherDataFetcher->shouldReceive('fetchCurrentWeather')
            ->with(Mockery::type(WeatherRequestData::class), Mockery::any())
            ->andReturn($this->mockWeatherResponse());

        $this->instance(WeatherDataFetcher::class, $mockWeatherDataFetcher);

        $response = $this->getJson("/api/weather");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'current_weather',
                    'raw_data',
                ]
            ])
            ->assertJson([
                'data' => [
                    'current_weather' => 'cloudy',
                    'raw_data' => null,
                ]
            ]);
    }

    private function mockWeatherResponse() {
        $mockResponse = Mockery::mock(\Modules\Weather\Data\CurrentWeatherResponseData::class);
        $mockResponse->shouldReceive('webResponse')
            ->andReturn([
                'current_weather' => 'cloudy',
                'raw_data' => null
            ]);

        return $mockResponse;
    }
}
