<?php

namespace App\Http\Controllers\Docs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface CardControllerDocs
{
    #[OA\Get(
        path:"/cards/search",
        summary:"Search Magic cards",
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
            new OA\Response(response:200, description:"Card results")
        ]
    )]
    public function search(Request $req);
}