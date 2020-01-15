<?php

namespace App\Http\Controllers;

use App\Services\OpenWeatherMap;
use Illuminate\Routing\Controller;

class Forecaster extends Controller
{
    public $service;
    public function __construct(OpenWeatherMap $weather_service)
    {
        $this->service = $weather_service;
    }

    public function daily($city)
    {
        return $this->service->get_forcast($city);
    }
}
