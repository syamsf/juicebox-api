<?php

namespace Modules\Weather\Data;

class WeatherErrorMessageData {
    public function __construct(
        public readonly bool    $isError = false,
        public readonly ?string $message = null,
        public readonly ?string $code = null,
        public readonly ?int    $httpCode = null,
        public readonly ?string $rawErrorMessage = null,
    ) {
    }

    public static function error(
        ?string $message = null,
        ?string $code = null,
        ?int    $httpCode = null,
        ?string $rawErrorMessage = null
    ): self {
        return new self(
            isError: true,
            message: $message,
            code: $code,
            httpCode: $httpCode,
            rawErrorMessage: $rawErrorMessage
        );
    }

    public static function notError(): self {
        return new self();
    }
}
