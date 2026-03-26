<?php 

namespace App\Services;

use App\Models\Card;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardService
{
    public static $types = [
        'planeswalkers' => [
            'type' => 'Planeswalker',
            'label' => 'Planeswalkers',
            'items' => []
        ],
        'creatures' => [
            'type' => 'Creature',
            'label' => 'Creatures',
            'items' => []
        ], 
        'sorceries' => [
            'type' => 'Sorcery',
            'label' => 'Sorceries',
            'items' => []
        ], 
        'instants' => [
            'type' => 'Instant',
            'label' => 'Instants',
            'items' => []
        ], 
        'artifacts' => [
            'type' => 'Artifact',
            'label' => 'Artifacts',
            'items' => []
        ], 
        'enchantments' => [
            'type' => 'Enchantment',
            'label' => 'Enchantments',
            'items' => []
        ], 
        'lands' => [
            'type' => 'Land',
            'label' => 'Lands',
            'items' => []
        ], 
        'others' => [
            'type' => 'Other',
            'label' => 'Other',
            'items' => []
        ]
    ];

    public function __construct(protected ScryfallService $scryfall) {}

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

    public static function setCustomDetails(Card $card): Card
    {
        $card->quantity = $card->pivot->quantity;
        $card->image_url = $card->pivot->image_url;
        $card->extra_image = $card->pivot->extra_image;
        $card->name = $card->pivot->printed_name;
        
        // set card type
        $other = true;
        foreach(self::$types as $key => $type) {
            if (str_contains($card->type_line, $type['type'])) {
                $card->type = $key;
                $other = false;
                break;
            }
        }
        if ($other)
            $card->type = 'others';

        unset($card->pivot);
        return $card;
    }

    public static function groupCardsByType(array $cards) : array
    {
        foreach ($cards as $card) {
            $other = true;
            foreach (self::$types as $key => $type) {
                // if same card type
                if (str_contains($card['type_line'], $type['type'])) {
                    self::$types[$key]['items'][] = $card;
                    $other = false;
                    break;
                }
            }

            if ($other)
                self::$types['others']['items'][] = $cards;
        }

        foreach (self::$types as $key => $type) {
            self::$types[$key]['count'] = array_sum(array_column($type['items'], 'quantity'));
        }

        return self::$types;
    } 


    public function cacheData()
    {
        try {
            Log::info('Getting download link...');
            $result = $this->scryfall->bulkData();
            $downloadLink = $result['download_uri'] ?? '';
            if (!$downloadLink) {
                Log::error('Could not get bulk data download link');
                return;
            }

            Log::info('Downloading cards data file...');
            $destinationPath = storage_path('app/cards_data.json'); 
            Http::timeout(600)->sink($destinationPath)->get($downloadLink);

            // save data
            Log::info('Saving cards to database...');

        } catch (\Exception $e) {
            Log::error("Error while caching card data" . $e->getMessage());
            return null;
        }
    }
}