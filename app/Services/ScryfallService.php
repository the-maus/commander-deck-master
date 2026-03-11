<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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
        // avoid "HTTP 429 Too Many Requests"
        usleep(100 * 1000); // 100 milisseconds

        $response = $this->client->get(self::BASE_URL . "/cards/search", ['q' => "\"$query\"", 'include_multilingual' => true]);

        return $response->json()['data'] ?? [];
    }
}