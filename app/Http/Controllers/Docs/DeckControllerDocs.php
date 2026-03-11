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
                required: ['name', 'commander_name', 'commander_colors', 'image_url'],
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
                        property: 'commander colors',
                        type: 'string',
                        enum: Card::COLORS,
                        description: 'Array containing the color codes',
                        example: '["G", "W", "U", "B"]'
                    ),
                    new OA\Property(
                        property: 'image_url',
                        type: 'string',
                        description: 'URL for the selected commander card print variation image',
                        example: 'https://cards.scryfall.io/normal/front/d/0/d0d33d52-3d28-4635-b985-51e126289259.jpg?1599707796'
                    ),
                ],
            ),
        ),
        // TODO change
        responses: [
            new OA\Response(
                response: 201,
                description: 'Post created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'My new post title'),
                        new OA\Property(property: 'content', type: 'string', example: 'The actual content of the post.'),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The title field is required.'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            )
        ]
    )]
    public function create(Request $req);
}