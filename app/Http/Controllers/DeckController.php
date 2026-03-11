<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Docs\DeckControllerDocs;
use App\Models\Card;
use App\Models\Deck;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeckController extends Controller implements DeckControllerDocs
{
    
    public function create(Request $req)
    {
        $req->validate([
            'name'               => 'string|required|max:255',
            'commander_name'     => 'string|required|max:255',
            'commander_colors'   => 'required|array',
            'commander_colors.*' => Rule::in(Card::COLORS),
            'image_url'          => 'string|required'
        ]);

        $deck = Deck::create($req->all());

        return ApiResponse::success($deck, 201);
    }
}
