<?php

namespace App\Http\Controllers\Docs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface CardControllerDocs
{
    #[OA\Get(
        path:"/cards/search",
        summary:"Search cards",
        description:"Search cards using the Scryfall API",
        tags:["Cards"],
        parameters:[
            new OA\Parameter(
                name:"q",
                in:"query",
                required:true,
                description:"Search query",
                schema: new OA\Schema(type:"string", example:"sol ring")
            )
        ],
        responses:[
            new OA\Response(response:200, description:"Card results"),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The q is required.'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            )
        ]
    )]
    public function search(Request $req);

    #[OA\Get(
        path:"/cards/prints",
        summary:"Get card print variations",
        description:"Get cards print variations using the Scryfall API",
        tags:["Cards"],
        parameters:[
            new OA\Parameter(
                name:"oracle_id",
                in:"query",
                required:true,
                description:"Oracle ID for the card on Scryfall",
                schema: new OA\Schema(type:"string", example:"b828ba28-e98d-498b-9ab4-d4aa7143e407")
            )
        ],
        responses:[
            new OA\Response(response:200, description:"Prints urls"),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The oracle_id field is required.'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            )
        ]
    )]
    public function getCardPrints(Request $req);
}