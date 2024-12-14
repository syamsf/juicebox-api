<?php

namespace Modules\SharedCommon\Exceptions\CustomException;

use Illuminate\Support\Facades\Log;
class NoReportException extends \Exception {
    public function __construct(
        ErrorType $errorType = ErrorType::ERROR,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
        array $context = []
    ) {
        $completeContext = array_merge($context, ["error_code" => $code]);

        if ($errorType == ErrorType::ERROR) {
            Log::error($message, $completeContext);
        } elseif ($errorType == ErrorType::INFO) {
            Log::info($message, $completeContext);
        } elseif ($errorType == ErrorType::WARN) {
            Log::warning($message, $completeContext);
        } elseif ($errorType == ErrorType::DEBUG) {
            Log::debug($message, $completeContext);
        }

        parent::__construct($message, $code, $previous);
    }
}
