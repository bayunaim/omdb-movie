<?php

namespace App\Services;

use GuzzleHttp\Client;

class OmdbService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OMDB_API_KEY');
        $this->baseUrl = env('OMDB_API_URL');
    }

    public function search($params)
    {
        $query = array_merge(['apikey' => $this->apiKey], $params);
        $response = $this->client->get($this->baseUrl, ['query' => $query]);

        return json_decode($response->getBody(), true);
    }

    public function getById($id)
    {
        $response = $this->client->get($this->baseUrl, [
            'query' => [
                'apikey' => $this->apiKey,
                'i' => $id,
                'plot' => 'full'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
