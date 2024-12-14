<?php declare(strict_types = 1);

namespace Modules\SharedCommon\Data;

use Symfony\Component\HttpFoundation\Response;

class APIResponseData {
    public function __construct(
        public readonly int $httpCode      = Response::HTTP_OK,
        public readonly bool $isSuccess    = true,
        public string $message             = '',
        public readonly ?array $links      = null,
        public readonly ?array $pagination = null
    ) {
    }

    public static function success(
        string $message = '',
        ?array $links = null,
        ?array $pagination = null,
        int $httpCode = Response::HTTP_OK,
    ): self {
        return new self (
            httpCode: $httpCode,
            isSuccess: true,
            message: $message,
            links: $links,
            pagination: $pagination
        );
    }

    public static function failed(
        string $message = '',
        ?array $links = null,
        ?array $pagination = null,
        int $httpCode = Response::HTTP_BAD_REQUEST,
    ): self {
        return new self (
            httpCode: $httpCode,
            isSuccess: false,
            message: $message,
            links: $links,
            pagination: $pagination
        );
    }

    public function message(string $message): self {
        if (empty($message))
            throw new \Exception("message is required");

        $this->message = $message;
        return $this;
    }
}
