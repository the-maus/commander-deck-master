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

        $response = $this->scryfall->search(['query' => $req->q]);

        return ApiResponse::success($response);
    }

    public function getCardPrints(Request $req)
    {
        $req->validate(['oracle_id' => 'required']);

        $cards = $this->scryfall->search(['oracle_id' => $req->oracle_id, 'unique' => 'prints']);
        $prints = array_column(array_column($cards, 'image_uris'), 'normal');

        return ApiResponse::success($prints);
    }

    public function autoComplete(Request $req)
    {
        $req->validate(['q' => 'required']);

        $response = $this->scryfall->autoComplete($req->q);

        return ApiResponse::success($response);
    }

}
