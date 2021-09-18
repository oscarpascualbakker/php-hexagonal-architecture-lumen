<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use src\Shared\Metrics\Infrastructure\MetricsController as InfrastructureController;


class MetricsController extends Controller
{

    private InfrastructureController $metricsController;


    public function __construct(InfrastructureController $metricsController)
    {
        $this->metricsController = $metricsController;
    }


    public function show()
    {
        return $this->metricsController->show();
    }

}
