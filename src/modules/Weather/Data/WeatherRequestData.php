<?php

namespace Modules\Weather\Data;

class WeatherRequestData {
    public function __construct(
        public readonly string $city,
    ) {
    }

    public static function make(string $city): self {
        return new self(
            city: trim(strtolower($city)),
        );
    }
}
