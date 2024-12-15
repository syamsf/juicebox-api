<?php

namespace Modules\Weather\Commands;

use Illuminate\Console\Command;
use Modules\Weather\Action\WeatherDataFetcher;
use Modules\Weather\Data\WeatherRequestData;

class FetchWeatherCommand extends Command {
    protected $signature = 'weather:current';

    protected $description = 'Fetch the current weather for a given city';

    /**
     * @throws \Exception
     */
    public function handle(WeatherDataFetcher $dataFetcher): void {
        $dataFetcher->fetchCurrentWeather(WeatherRequestData::make("perth"), config("weather.adapter"));

        $this->info('Fetched weather successfully.');
    }
}
