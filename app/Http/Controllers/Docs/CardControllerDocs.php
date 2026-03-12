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
                        new OA\Property(property: 'message', type: 'string', example: 'The title field is required.'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            )
        ]
    )]
    public function search(Request $req);
}