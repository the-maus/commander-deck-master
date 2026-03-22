<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Docs\DeckControllerDocs;
use App\Models\Card;
use App\Models\Deck;
use App\Services\ApiResponse;
use App\Services\DeckService;
use App\Services\ScryfallService;
use Illuminate\Http\Request;

class DeckController extends Controller implements DeckControllerDocs
{
    public function __construct(
        protected ScryfallService $scryfall,
        protected DeckService $deckService
    ) {}

    public function index(Request $req)
    {
        $decks = Deck::orderBy('name')->paginate(12, ['id', 'name', 'commander_name', 'art_crop']);

        return ApiResponse::success($decks);
    }

    public function create(Request $req)
    {
        $this->validateDeckData($req);

        $cardInfo = $this->scryfall->named($req->commander_name);
        if (!isset($cardInfo['id']))
            return ApiResponse::error('Card not found', 404);

        $deck = Deck::create(DeckService::parseCommanderData($req->name, $cardInfo));

        return ApiResponse::success($deck, 201);
    }

    public function update(Request $req, string $id)
    {
        $this->validateDeckData($req);
        $deck = Deck::find($id);
        if (!$deck)
            return ApiResponse::error('Deck not found', 404);

        $cardInfo = $this->scryfall->named($req->commander_name);
        if (!isset($cardInfo['id']))
            return ApiResponse::error('Card not found', 404);

        $deck->update(DeckService::parseCommanderData($req->name, $cardInfo));
        return ApiResponse::success($deck);
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
        $result = Deck::with('cards')->find($id);
        
        if ($result) {
            $deck = $result->toArray();
            $deck['cards'] = $result->cards()->withPivot('quantity', 'image_url', 'extra_image', 'printed_name')->get()->map(function($card){
                $card->quantity = $card->pivot->quantity;
                $card->image_url = $card->pivot->image_url;
                $card->extra_image = $card->pivot->extra_image;
                $card->name = $card->pivot->printed_name;
                unset($card->pivot);
                return $card;
            });
            return ApiResponse::success($deck);
        } else
            return ApiResponse::error('Deck not found', 404);
    }

    public function delete(string $id)
    {
        $deck = Deck::find($id);

        if ($deck) {
            $deck->delete();
            return ApiResponse::success('Deck deleted successfully');
        } else
            return ApiResponse::error('Deck not found', 404);
    }

    public function addCard(Request $req, string $id)
    {
        $req->validate([
            'card_name' => 'string|required|max:255',
            'image_url' => 'string',
            'extra_image' => 'string'
        ]);

        // get deck (commander) info
        $deck = Deck::find($id);
        if (!$deck)
            return ApiResponse::error('Deck not found', 404);

        // get card info
        $cardData = $this->scryfall->named($req->card_name);
        if (!$cardData || !isset($cardData['id']))
            return ApiResponse::error('Card not found', 404);

        $result = $this->deckService->addCardToDeck($deck, $cardData, $req->all());
        if ($result !== true)
            return ApiResponse::error($result);
        else
            return ApiResponse::success('Card added successfully');
    }
}
