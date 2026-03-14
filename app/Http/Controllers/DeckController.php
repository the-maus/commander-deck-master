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

    public function index(Request $req) 
    {
        $decks = Deck::orderBy('name')->paginate(2, ['id', 'name', 'commander_name', 'art_crop']);

        return ApiResponse::success($decks);
    }
    
    public function create(Request $req)
    {
        $this->validateDeckData($req);

        $deck = Deck::create($req->all());

        return ApiResponse::success($deck, 201);
    }

    public function update(Request $req, string $id)
    {
        $this->validateDeckData($req);

        $deck = Deck::find($id);
        if ($deck) {
            $deck->update($req->all());
            return ApiResponse::success($deck);
        }else
            return ApiResponse::error('Deck not found', 404);
    }


    private function validateDeckData(Request $req)
    {
        $req->validate([
            'name'               => 'string|required|max:255',
            'commander_name'     => 'string|required|max:255',
            'commander_colors'   => 'required|array',
            'commander_colors.*' => Rule::in(Card::COLORS),
            'image_url'          => 'string|required',
            'art_crop'           => 'string|required'
        ]);
    }

    public function show(string $id)
    {
        $deck = Deck::find($id);

        if ($deck)
            return ApiResponse::success($deck);
        else
            return ApiResponse::error('Deck not found', 404);
    }

    public function delete(string $id)
    {
        $deck = Deck::find($id);

        if ($deck) {
            $deck->delete();
            return ApiResponse::success('Deck deleted successfully!');
        }else
            return ApiResponse::error('Deck not found', 404);
    }
}
