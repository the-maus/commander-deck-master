<?php

namespace App\Http\Controllers\Docs;

use App\Models\Card;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface DeckControllerDocs
{
    #[OA\Post(
        path: '/api/decks',
        summary: 'Create a new deck',
        tags:["Decks"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                required: ['name', 'commander_name'],
                properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        description: 'The deck name',
                        example: 'Atraxa superfriends'
                    ),
                    new OA\Property(
                        property: 'commander_name',
                        type: 'string',
                        description: 'The commander card name',
                        example: "Atraxa, Praetors' Voice"
                    ),
                    new OA\Property(
                        property: 'image_url',
                        type: 'string',
                        description: 'URL for the selected commander card print variation image',
                        example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'
                    ),
                    new OA\Property(
                        property: 'art_crop',
                        type: 'string',
                        description: 'URL for the selected commander card art',
                        example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'
                    ),
                ],
            ),
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Deck created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Atraxa superfriends'),
                        new OA\Property(property: 'commander_name', type: 'string', example: 'Atraxa, Praetors\' Voice'),
                        new OA\Property(property: 'commander_colors', type: 'array', example: '["G", "W", "U", "B"]', items: new OA\Items(type: 'string')),
                        new OA\Property(property: 'image_url', type: 'string', example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'),
                        new OA\Property(property: 'art_crop', type: 'string', example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'),
                        new OA\Property(property: 'created_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                        new OA\Property(property: 'updated_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The name field is required.'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            )
        ]
    )]
    public function create(Request $req);

    #[OA\Put(
        path: '/api/decks/{id}',
        summary: 'Update an existing deck',
        tags:["Decks"],
        parameters:[
            new OA\Parameter(
                name:"id",
                in:"path",
                required:true,
                description:"The deck unique ID",
                schema: new OA\Schema(type:"integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                required: ['name', 'commander_name', 'commander_colors', 'image_url', 'art_crop'],
                properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        description: 'The deck name',
                        example: 'Atraxa superfriends'
                    ),
                    new OA\Property(
                        property: 'commander_name',
                        type: 'string',
                        description: 'The commander card name',
                        example: "Atraxa, Praetors' Voice"
                    ),
                    new OA\Property(
                        property: 'image_url',
                        type: 'string',
                        description: 'URL for the selected commander card print variation image',
                        example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'
                    ),
                    new OA\Property(
                        property: 'art_crop',
                        type: 'string',
                        description: 'URL for the selected commander card art',
                        example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'
                    ),
                ],
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Deck updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Atraxa superfriends'),
                        new OA\Property(property: 'commander_name', type: 'string', example: 'Atraxa, Praetors\' Voice'),
                        new OA\Property(property: 'commander_colors', type: 'array', example: '["G", "W", "U", "B"]', items: new OA\Items(type: 'string')),
                        new OA\Property(property: 'image_url', type: 'string', example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'),
                        new OA\Property(property: 'art_crop', type: 'string', example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'),
                        new OA\Property(property: 'created_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                        new OA\Property(property: 'updated_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The name field is required.'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            )
        ]
    )]
    public function update(Request $req, string $id);

    #[OA\Get(
        path: '/api/decks/{id}',
        summary: 'Get info for an existing deck',
        tags:["Decks"],
        parameters:[
            new OA\Parameter(
                name:"id",
                in:"path",
                required:true,
                description:"The deck unique ID",
                schema: new OA\Schema(type:"integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Deck data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Atraxa superfriends'),
                        new OA\Property(property: 'commander_name', type: 'string', example: 'Atraxa, Praetors\' Voice'),
                        new OA\Property(property: 'commander_colors', type: 'array', example: '["G", "W", "U", "B"]', items: new OA\Items(type: 'string')),
                        new OA\Property(property: 'image_url', type: 'string', example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'),
                        new OA\Property(property: 'art_crop', type: 'string', example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'),
                        new OA\Property(property: 'created_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                        new OA\Property(property: 'updated_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Not found error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Deck not found'),
                        new OA\Property(property: 'status_code', type: 'integer'),
                    ]
                )
            )
        ]
    )]
    public function show(string $id);

    #[OA\Delete(
        path: '/api/decks/{id}',
        summary: 'Delete an existing deck',
        tags:["Decks"],
        parameters:[
            new OA\Parameter(
                name:"id",
                in:"path",
                required:true,
                description:"The deck unique ID",
                schema: new OA\Schema(type:"integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Deck deleted successfully',
            ),
            new OA\Response(
                response: 404,
                description: 'Not found error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Deck not found'),
                        new OA\Property(property: 'status_code', type: 'integer'),
                    ]
                )
            )
        ]
    )]
    public function delete(string $id);

    #[OA\Get(
        path: '/api/decks',
        summary: 'Lists decks',
        tags:["Decks"],
        parameters:[
            new OA\Parameter(
                name:"page",
                in:"query",
                required:true,
                description:"The list page",
                schema: new OA\Schema(type:"integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'A deck list with fewer properties (below) and the pagination data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Atraxa superfriends'),
                        new OA\Property(property: 'art_crop', type: 'string', example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'),
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function index(Request $req);

    #[OA\Put(
        path: '/api/decks/{id}/add-card',
        summary: 'Add card to an existing deck',
        tags:["Decks"],
        parameters:[
            new OA\Parameter(
                name:"id",
                in:"path",
                required:true,
                description:"The deck unique ID",
                schema: new OA\Schema(type:"integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                required: ['name'],
                properties: [
                    new OA\Property(
                        property: 'card_name',
                        type: 'string',
                        description: 'The name of the card to be added on the deck',
                        example: 'Swords to Plowshares'
                    ),
                    new OA\Property(
                        property: 'image_url',
                        type: 'string',
                        description: 'URL for alternative card print image',
                        example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'
                    ),
                    new OA\Property(
                        property: 'extra_image',
                        type: 'string',
                        description: 'URL for the extra card image\'s (for double faced cards) alternative art',
                        example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'
                    ),
                ],
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Deck updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Atraxa superfriends'),
                        new OA\Property(property: 'commander_name', type: 'string', example: 'Atraxa, Praetors\' Voice'),
                        new OA\Property(property: 'commander_colors', type: 'array', example: '["G", "W", "U", "B"]', items: new OA\Items(type: 'string')),
                        new OA\Property(property: 'image_url', type: 'string', example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'),
                        new OA\Property(property: 'art_crop', type: 'string', example: 'https://cards.scryfall.io/art_crop/front/1/c/1cc9e7cb-d4f4-4f06-b232-f91eb39fe1b3.jpg?1734853541'),
                        new OA\Property(property: 'created_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                        new OA\Property(property: 'updated_at', type: 'string', example: '2026-03-11T22:50:26.000000Z', format: 'date-time'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The name field is required.'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            )
        ]
    )]
    public function addCard(Request $req, string $id);
}