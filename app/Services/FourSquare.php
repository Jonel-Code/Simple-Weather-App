<?php
namespace App\Services;

use GuzzleHttp\Client as HttpClient;

class FourSquare
{
    private $base_url;
    private $client_id;
    private $client_secret;
    private $venue_limit;
    private $api_version;
    private $url_version;
    private $http_client;

    public function __construct(HttpClient $client)
    {
        $this->base_url = env('FOUR_SQUARE_BASE_URL', 'api.foursquare.com');
        $this->client_id = env('FOUR_SQUARE_CLIENT_ID', '4YKWDAHR2TIQN4U1SKXPQXYAROZLQPU03RT1QXOUEYZO4YWZ');
        $this->client_secret = env('FOUR_SQUARE_CLIENT_SECRET', 'NO4EW32LTWEHUUWYHGWICMAE4OEEAGGO1SELZXXYNOVRNTKX');
        $this->api_version = env('FOUR_SQUARE_VERSION', '20180323');
        $this->url_version = env('FOUR_SQUARE_URL_VERSION', 'v2');
        $this->venue_limit = env('FOUR_SQUARE_VENUE_LIMIT', 5);
        $this->http_client = $client;
    }

    public function fetch_city_venue($city)
    {
        $venue = $this->http_client->get(
            $this->get_venue_url(),
            [
                'query' => array_merge(
                    $this->get_mapped_default_parameters(),
                    ['near' => "{$city},JP"]
                ),
                // set verify to false for ssl error fix
                'verify' => false,
            ]
        );
        return $this->map_venue_response(json_decode((string) $venue->getBody()));
    }

    public function map_venue_response($venue)
    {
        return [
            'display_name' => $venue->response->geocode->feature->displayName,
            'longitude' => $venue->response->geocode->feature->geometry->center->lng,
            'latitude' => $venue->response->geocode->feature->geometry->center->lat,
        ];
    }

    private function get_venue_url()
    {
        return "{$this->base_url}/{$this->url_version}/venues/search";
    }

    private function get_mapped_default_parameters()
    {
        return [
            'limit' => $this->venue_limit,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'v' => $this->api_version,
        ];
    }
}
