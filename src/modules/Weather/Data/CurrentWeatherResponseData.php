<?php

namespace Modules\Weather\Data;

class CurrentWeatherResponseData {
    public function __construct(
        public readonly ?string $currentWeather = null,
        public readonly ?array $rawData = null,
    ) {
    }

    public static function make(
        ?string $currentWeather = null,
        ?array $rawData = null,
    ): self {
        return new self(
            currentWeather: $currentWeather,
            rawData: $rawData,
        );
    }

    public function webResponse(): array {
        return [
            "current_weather" => $this->currentWeather,
            "raw_data"        => $this->rawData,
        ];
    }
}
