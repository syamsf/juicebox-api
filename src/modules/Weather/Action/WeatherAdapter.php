<?php

namespace Modules\Weather\Action;

use Modules\Weather\Action\Adapter\OpenWeatherMapAdapter;
use Modules\Weather\Action\Adapter\WeatherAdapterContract;
use Modules\Weather\Action\Adapter\WeatherApiAdapter;
use Modules\Weather\Enum\WeatherSource;

class WeatherAdapter {
    public function __construct(
        protected array $adapter = []
    ) {
        $this->registerTransporter(WeatherSource::DEFAULT->value, new OpenWeatherMapAdapter);
        $this->registerTransporter(WeatherSource::OPEN_WEATHER_MAP->value, new OpenWeatherMapAdapter);
        $this->registerTransporter(WeatherSource::WEATHER_API->value, new WeatherApiAdapter);
    }

    public function registerTransporter(string $key, WeatherAdapterContract $weatherAdapterLibs): void {
        $this->adapter[$key] = $weatherAdapterLibs;
    }

    public function getCurrentAdapter(?string $key = null): WeatherAdapterContract {
        return $this->adapter[$key] ?? $this->adapter['default'];
    }
}
