<?php

namespace App\Http\Controllers;

use App\Services\FourSquare;
use Illuminate\Routing\Controller;

class City extends Controller
{
    private $service;
    public function __construct(FourSquare $four_square_service)
    {
        $this->service = $four_square_service;
    }

    public function venue_information($city)
    {
        return $this->service->fetch_city_venue($city);
    }

    function list() {
        return response()->json(['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya']);
    }
}
