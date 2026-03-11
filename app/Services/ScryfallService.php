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

    public function search($query)
    {
        $parameters = ['q' => $query, 'include_multilingual' => true];

        return $this->makeRequest($parameters);
    }

    private function makeRequest($parameters = [], $endpoint = '/cards/search')
    {
        // avoid "HTTP 429 Too Many Requests"
        usleep(100 * 1000); // 100 milisseconds

        $response = $this->client->get(self::BASE_URL . $endpoint, $parameters);
        if(!$response->successful())
            Log::error("Unexpected Api Response Status Code: {$response->status()}", $response->json());
    
        return $response->json()['data'] ?? [];
    }
}