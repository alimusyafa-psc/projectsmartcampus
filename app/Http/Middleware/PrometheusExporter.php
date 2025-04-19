<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis;

class PrometheusExporter
{
    private $registry;

    public function __construct()
    {
        $redisAdapter = new Redis([
            'host' => env('REDIS_HOST', 'redis'), // pastikan Redis bisa diakses dari sini
            'port' => env('REDIS_PORT', 6379),
        ]);

        $this->registry = new CollectorRegistry($redisAdapter);
    }

    public function handle(Request $request, Closure $next)
    {
        // Mulai timer
        $start = microtime(true);

        // Eksekusi request dan ambil response
        $response = $next($request);

        // Hitung durasi request
        $duration = microtime(true) - $start;

        // Daftarkan metrik
        $counter = $this->registry->getOrRegisterCounter(
            'app',
            'http_requests_total',
            'Jumlah total HTTP request',
            ['method', 'route', 'status_code']
        );

        $histogram = $this->registry->getOrRegisterHistogram(
            'app',
            'http_request_duration_seconds',
            'Durasi permintaan dalam detik',
            ['method', 'route'],
            [0.1, 0.5, 1, 2.5, 5]
        );

        // Dapatkan nama route
        $route = optional($request->route())->uri() ?? 'unknown';

        // Simpan metrik
        $counter->inc([$request->method(), $route, $response->getStatusCode()]);
        $histogram->observe($duration, [$request->method(), $route]);

        return $response;
    }

    public function exportMetrics()
    {
        $renderer = new RenderTextFormat();
        $metrics = $renderer->render($this->registry->getMetricFamilySamples());

        return response($metrics)->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
