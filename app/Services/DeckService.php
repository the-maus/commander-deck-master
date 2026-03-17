<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Deck;
use App\Models\DeckCard;
use Illuminate\Support\Facades\Log;

class DeckService
{
    public function __construct(
        protected ScryfallService $scryfall,
        protected CardService $cardService
    ) {}

    public function addCardToDeck(Deck $deck, $cardData, $request = []): bool|string
    {
        try {
            $validation = $this->validateCardOnDeck($deck, $cardData);
            if ($validation !== true)
                return $validation;

            // create card
            /** @var Card $card */
            $card = $this->cardService->getOrCreateCard($cardData);
            if (!$card)
                return "An error occured while saving the card";

            /** @var DeckCard $deckCard */ 
            $deckCard = $deck->cards()->withPivot('quantity')->where('card_id', $card->id)->first();
            $quantity = 1;

            // if card's already on deck (aka basic land), just increment quantity
            if ($deckCard) {
                $quantity += $deckCard->pivot->quantity;
                $deck->cards()->updateExistingPivot($card->id, compact('quantity'));
            } else { // add card to deck
                $image_url = $request['image_url'] ?? $cardData['image_uris']['normal'];
                $extra_image = $request['extra_image'] ?? $cardData['card_faces'][1]['image_uris']['normal'] ?? '';
                $printed_name = $cardData['printed_name'] ?? $cardData['name'];

                $deck->cards()->attach($card->id, compact('quantity', 'image_url', 'extra_image', 'printed_name'));
            }
        } catch (\Exception $e) {
            Log::error("Error while adding card to deck: " . $e->getMessage(), compact('deck', 'cardData', 'request'));
            return "Sorry, an occurred when adding card to deck";
        }

        return true;
    }

    private function validateCardOnDeck(Deck $deck, $cardData)
    {
        // validate color identity
        if (!empty($cardData['color_identity']) && !empty(array_diff($cardData['color_identity'], $deck->commander_colors)))
            return "The card doesn't fit within the commander's color identity";

        // validate if added card is legal in commander
        if (!isset($cardData['legalities']['commander']) || $cardData['legalities']['commander'] !== 'legal')
            return "This card is not legal in commander";

        // validate if card's already in deck
        if (!str_contains($cardData['type_line'], 'Basic Land')) {
            if ($deck->cards()->where('scryfall_id', $cardData['oracle_id'])->exists())
                return "This card is already on the deck";
        }

        return true;
    }

    public static function parseCommanderData($name, $data)
    {
        $imageUris = $data['image_uris'] ?? $data['card_faces'][0]['image_uris'];

        return [
            'name' => $name,
            'commander_name' => $data['printed_name'] ?? $data['name'],
            'commander_colors' => $data['color_identity'],
            'image_url' => $imageUris['normal'],
            'art_crop' => $imageUris['art_crop']
        ];
    }
}
