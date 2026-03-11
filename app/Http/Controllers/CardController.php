<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Docs\CardControllerDocs;
use App\Services\ApiResponse;
use App\Services\ScryfallService;
use Illuminate\Http\Request;


class CardController extends Controller implements CardControllerDocs
{
    public function __construct(protected ScryfallService $scryfall) {}

    
    public function search(Request $req)
    {
        $req->validate(['q' => 'required']);

        $response = $this->scryfall->search($req->q);

        return ApiResponse::success($response);
    }
}
