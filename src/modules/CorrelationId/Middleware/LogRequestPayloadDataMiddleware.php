<?php

namespace Modules\CorrelationId\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestPayloadDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*')) {
            Log::info("Payload Data", [
                "detail" => [
                    "url"         => $request->getRequestUri(),
                    "http_method" => $request->method(),
                    "ip"          => $request->ip(),
                    "query_param" => $this->filterSensitiveData($request->query()),
                    "payload"     => $this->filterSensitiveData($request->except(request()->query->keys())),
                ],
            ]);
        }

        return $next($request);
    }

    public function filterSensitiveData(array $data): array {
        return array_filter($data, function ($key) {
            $excludedContent = ["password", "token"];

            foreach ($excludedContent as $exclude) {
                if (str_contains($key, $exclude)) {
                    return false;
                }
            }

            return true;
        }, ARRAY_FILTER_USE_KEY);
    }
}
