<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScryfallService
{
    const BASE_URL = 'https://api.scryfall.com';

    protected $client;

    public function __construct()
    {
        $userAgent = 'CommanderDeckMaster/1.0.0 (msampaio.mail@gmail.com)';
        $this->client = Http::acceptJson()->withUserAgent($userAgent);
    }

    public function search($options = [])
    {
        $parameters = [];
        $lang =  $options['lang'] ?? 'en';

        if (isset($options['query']))
            $parameters['q'] = $options['query'];

        if (isset($options['oracle_id']))
            $parameters['q'] = "oracleid:{$options['oracle_id']}";

        if (isset($options['unique']))
            $parameters['unique'] = $options['unique'];

        $parameters['q'] = ($parameters['q'] ?? '') . " lang:$lang";

        return $this->makeRequest($parameters);
    }

    public function autoComplete($query)
    {
        return $this->makeRequest(['q' => $query], '/cards/autocomplete');
    }

    public function named($fuzzy)
    {
        return $this->makeRequest(compact('fuzzy'), '/cards/named', false);
    }

    private function makeRequest($parameters = [], $endpoint = '/cards/search', $getData = true)
    {
        // avoid "HTTP 429 Too Many Requests"
        usleep(100 * 1000); // 100 milisseconds

        $response = $this->client->get(self::BASE_URL . $endpoint, $parameters);
        if(!$response->successful())
            Log::error("Unexpected Api Response Status Code: {$response->status()}", $response->json());
        
        if ($getData)
            return $response->json()['data'] ?? [];
        else 
            return $response->json() ?? [];
    }
}