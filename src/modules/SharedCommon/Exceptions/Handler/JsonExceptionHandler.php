<?php declare(strict_types = 1);

namespace Modules\SharedCommon\Exceptions\Handler;

use Modules\SharedCommon\Exceptions\CustomException\ExceptionFactory;
use Modules\SharedCommon\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class JsonExceptionHandler {
    public function render($request, Throwable $e): bool|JsonResponse {
        $contentType = $request->headers->get("content-type");
        $isFormData  = !empty($contentType) && str_contains($contentType, "multipart/form-data");

        if (empty($contentType)) {
            $request->headers->add(["content-type" => "application/json"]);
        }

        if (!$request->isJson() && !$isFormData)
            return false;

        $errors         = null;
        $exceptionTrace = $e->getTrace();

        /**
         * Why there's json_encode over here and there's json_last_error() checks?
         *   Because there's a recursion problem when Laravel's response()->json() tries to encode the exception trace
         *   into JSON.
         *   The problem is "RECURSION DETECTED".
         *
         * Caused by:
         *   - Illegal character in error traces that tries to encode into JSON
         */
        json_encode($e->getTrace());

        $errorCode = null;

        switch (true) {
            case $e instanceof NotFoundException || $e instanceof NotFoundHttpException:
                $e = $this->notFoundResponse($e);
                break;
            case $e instanceof ModelNotFoundException:
                $e = $this->notFoundModelResponse($e);
                break;
            case $e instanceof ValidationException:
                $errors    = $e->errors();
                $errorCode = 400;
                break;
            case $e instanceof AMQPExceptionInterface:
                unset($exceptionTrace[1]);
                unset($exceptionTrace[2]);
                $exceptionTrace = array_values($exceptionTrace);
                break;
            default:
                break;
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            $exceptionTrace = $e->getTraceAsString();
        }

        $response = [
            'error'   => true,
            'code'    => is_null($errorCode) ? $this->getExceptionStatusCode($e) : $errorCode,
            'success' => false,
            'message' => $e->getMessage(),
            'detail'  => $errors
        ];

        if (config('app.debug'))
            $response['trace'] = $exceptionTrace;

        $errorCode = empty($errorCode) ? $this->getExceptionStatusCode($e) : $errorCode;

        return response()->json($response, $errorCode);
    }

    protected function getExceptionStatusCode(Throwable $exception): int {
        if (method_exists($exception, 'getCode')) {
            $isErrorCodeInt = is_int($exception->getCode());
            $errorCode      = $isErrorCodeInt ? $exception->getCode() : 500;
            return $errorCode > 599 || $errorCode < 100 ? 500 : $errorCode;
        }

        return 500;
    }

    public function notFoundResponse(Throwable $exception): \Throwable {
        return new \Exception($exception->getMessage(), Response::HTTP_NOT_FOUND);
    }

    public function notFoundModelResponse(Throwable $exception): \Throwable {
        $filteredModel = str_replace("No query results for model [App\\Models\\", "", $exception->getMessage());
        $filteredModel = str_replace("].", "", $filteredModel);
        return new \Exception("{$filteredModel} data not found", Response::HTTP_NOT_FOUND);
    }

    public function jwtAuthException(Throwable $exception): \Throwable {
        return ExceptionFactory::jwtException($exception->getMessage(), 400);
    }
}
