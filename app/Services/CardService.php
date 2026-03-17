<?php 

namespace App\Services;

use App\Models\Card;
use Illuminate\Support\Facades\Log;

class CardService
{
    public function getOrCreateCard($cardData)
    {
        try {
            return Card::firstOrCreate(
                ['scryfall_id' => $cardData['oracle_id']],
                [
                    'scryfall_id' => $cardData['oracle_id'],
                    'name' => $cardData['name'],
                    'mana_cost' => $cardData['mana_cost'],
                    'cmc' => intval($cardData['cmc']),
                    'colors' => $cardData['color_identity'],
                    'type_line' => $cardData['type_line']
                ]
            );
        } catch (\Exception $e) {
            Log::error("Error while getting/creating card " . $e->getMessage(), $cardData);
            return null;
        }
    }

    public static function parseCardData($cardData)
    {
        // adding default images for double-faced cards
        if (!isset($cardData['image_uris']) && isset($cardData['card_faces'][0]['image_uris']))
            $cardData['image_uris'] = $cardData['card_faces'][0]['image_uris'];

        return $cardData;
    }
}