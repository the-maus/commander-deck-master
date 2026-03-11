<?php

namespace App\Annotations;
use OpenApi\Attributes as OA;

/**
 * @OA\Info(
 *     title="Commander Deck Builder API",
 *     version="1.0.0",
 *     description="API for building and analyzing Commander decks for Magic: The Gathering"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local API server"
 * )
 */
class OpenApi
{
}