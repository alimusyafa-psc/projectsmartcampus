<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis;
use Symfony\Component\HttpFoundation\Response;

class PrometheusExporter
{
    private $registry;
    protected $prometheus;

    public function __construct()
    {
        
        $redisAdapter = new Redis([
            'host' => 'redis',
            'port' => 6379,
        ]);

        $this->registry = new CollectorRegistry($redisAdapter);
    }

    public function handle(Request $request, Closure $next)
    {
        $requestCounter = $this->registry->getOrRegisterCounter('app', 'http_requests_total', 'Total number of requests', ['method', 'route', 'status_code']);
        $requestDuration = $this->registry->getOrRegisterHistogram('app', 'http_request_duration_seconds', 'Request duration', ['method', 'route'], [0.1, 0.5, 1, 5]);
        $counter = $this->prometheus->getCounter('laravel_http_requests_total', 'Jumlah permintaan HTTP ke aplikasi Laravel', ['method', 'status_code']);

        // Menangkap request dan status code
        $response = $next($request);

        // Increment metrik berdasarkan method dan status code
        $counter->incBy(1, [$request->method(), $response->status()]);
        
        return $response;
        $start = microtime(true);

        /** @var Response $response */
        $response = $next($request);

        $duration = microtime(true) - $start;

        $requestCounter->inc([$request->method(), $request->path(), $response->getStatusCode()]);
        $requestDuration->observe($duration, [$request->method(), $request->path()]);

        return $response;
    }

    public function exportMetrics()
    {
        $renderer = new RenderTextFormat();
        $metrics = $renderer->render($this->registry->getMetricFamilySamples());

        return response($metrics)
            ->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
