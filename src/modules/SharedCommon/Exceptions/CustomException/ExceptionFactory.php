<?php

namespace Modules\SharedCommon\Exceptions\CustomException;

class ExceptionFactory {
    public static function error(string $message = "", int $code = 0, ?\Throwable $previous = null, array $context = []): \Throwable {
        return new NoReportException(message: $message, code: $code, previous: $previous, context: $context);
    }

    public static function warn(string $message = "", int $code = 0, ?\Throwable $previous = null, array $context = []): \Throwable {
        return new NoReportException(errorType: ErrorType::WARN, message: $message, code: $code, previous: $previous, context: $context);
    }

    public static function info(string $message = "", int $code = 0, ?\Throwable $previous = null, array $context = []): \Throwable {
        return new NoReportException(errorType: ErrorType::INFO, message: $message, code: $code, previous: $previous, context: $context);
    }

    public static function debug(string $message = "", int $code = 0, ?\Throwable $previous = null, array $context = []): \Throwable {
        return new NoReportException(errorType: ErrorType::DEBUG, message: $message, code: $code, previous: $previous, context: $context);
    }

    public static function jwtException(string $message = "", int $code = 0, ?\Throwable $previous = null, array $context = []): \Throwable {
        $message = "JWT Exception: {$message}";
        return new NoReportException(errorType: ErrorType::INFO, message: $message, code: $code, previous: $previous, context: $context);
    }

    public static function authException(string $message = "Authentication Exception", int $code = 401, ?\Throwable $previous = null, array $context = []): \Throwable {
        return new NoReportException(errorType: ErrorType::INFO, message: $message, code: $code, previous: $previous, context: $context);
    }
}
