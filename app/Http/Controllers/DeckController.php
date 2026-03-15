<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Docs\DeckControllerDocs;
use App\Models\Card;
use App\Models\Deck;
use App\Services\ApiResponse;
use App\Services\ScryfallService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeckController extends Controller implements DeckControllerDocs
{
    public function __construct(protected ScryfallService $scryfall) {}

    public function index(Request $req) 
    {
        $decks = Deck::orderBy('name')->paginate(12, ['id', 'name', 'commander_name', 'art_crop']);

        return ApiResponse::success($decks);
    }
    
    public function create(Request $req)
    {
        $this->validateDeckData($req);

        $cardInfo = $this->scryfall->named($req->commander_name);
        if(!isset($cardInfo['id']))
            return ApiResponse::error('Card not found!', 404);

        $deck = Deck::create([
            'name' => $req->name,
            'commander_name' => $cardInfo['printed_name'] ?? $cardInfo['name'],
            'commander_colors' => $cardInfo['color_identity'],
            'image_url' => $cardInfo['image_uris']['normal'],
            'art_crop' => $cardInfo['image_uris']['art_crop'] 
        ]);

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
