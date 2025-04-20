<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Prometheus\CollectorRegistry;
use Prometheus\Histogram;
use Prometheus\Counter;
use Prometheus\Storage\Redis; // Atau APCu, jika kamu pakai itu

class PrometheusMiddleware
{
    private CollectorRegistry $registry;
    
    public function __construct(CollectorRegistry $registry)
    {
        $this->registry = $registry;
    }
  
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        $method = $request->method();
        $uri = $request->route()?->uri() ?? $request->path();

        try {
            $response = $next($request);
            $statusCode = $response->getStatusCode();
        } catch (\Throwable $e) {
            $statusCode = 500;
            throw $e;
        } finally {
            $duration = (microtime(true) - $startTime) * 1000;

            // Histogram untuk latency
            $histogram = $this->registry->getOrRegisterHistogram(
                'http_server_duration',
                'milliseconds',
                'Request duration histogram grouped by path and method',
                ['job', 'method', 'path'],
                Histogram::exponentialBuckets(1, 2, 15)
            );
            $histogram->observe($duration, ['Laravel', $method, $uri]);

            // Counter total request
            $counter = $this->registry->getOrRegisterCounter(
                'http_requests_total',
                'total',
                'Total HTTP requests by method, path, and status',
                ['job', 'method', 'path', 'status']
            );
            $counter->inc(['Laravel', $method, $uri, (string)$statusCode]);
        }

        return $response;
    }
}
