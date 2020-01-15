<?php

namespace App\Services;

use GuzzleHttp\Client as HttpClient;

class OpenWeatherMap
{
    public $open_weather_base_url;

    private $open_weather_app_id;
    private $http_client;

    public function __construct(HttpClient $client)
    {
        $this->open_weather_base_url = env('OPEN_WEATHER_BASE_URL', 'api.openweathermap.org');
        $this->open_weather_app_id = env('OPEN_WEATHER_APP_ID', 'daf02c61391f9f612411ad0bd83240ed');
        $this->http_client = $client;
    }

    public function map_weather_forcast($forcast)
    {
        $weather = [
            'city' => $forcast->city->name,
            'population' => $forcast->city->population,
        ];

        foreach ($forcast->list as $day) {
            $weather['dates'][] = [
                'forcast_date' => $day->dt,
                'temp_ave' => number_format((($day->temp->min + $day->temp->max) / 2) - 273.15, 2),
                'type' => $day->weather[0]->main,
                'description' => ucfirst($day->weather[0]->description),
                'precipitation' => isset($day->rain) ? $day->rain : 0,
                'humidity' => $day->humidity,
            ];
        }

        return $weather;
    }

    public function get_forcast($city)
    {
        $forcast = $this->http_client->get(
            "{$this->open_weather_base_url}/data/2.5/forecast/daily",
            [
                'query' => [
                    'q' => "{$city},JP",
                    'appid' => $this->open_weather_app_id,
                ],
            ]
        );
        return $this->map_weather_forcast(json_decode((string) $forcast->getBody()));
    }
}
