<?php

namespace src\Shared\Metrics\Infrastructure;

use Illuminate\Http\Response;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis;


/**
 * Useful information available here:
 * https://github.com/promphp/prometheus_client_php
 *
 */
final class MetricsController
{

    private $registry;


    public function __construct()
    {
        $adapter        = new Redis(['host' => 'redis']);
        $this->registry = new CollectorRegistry($adapter);
    }


    public function show(): Response
    {
        $renderer = new RenderTextFormat();
        $result   = $renderer->render($this->registry->getMetricFamilySamples());
        return (new Response($result, 200))
            ->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }


    public function incCounter($counter)
    {
        $counter = $this->registry->getOrRegisterCounter('api', $counter, 'Increases counter', ['type']);
        $counter->incBy(1, ['create']);
    }

}
