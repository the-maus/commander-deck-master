<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Card extends Model
{
    public const COLORS = ['W', 'U', 'B', 'R', 'G'];

    protected $fillable = [
        'scryfall_id',
        'name',
        'mana_cost',
        'cmc',
        'colors',
        'type_line'
    ];

    protected $casts = [
        'colors' => 'array'
    ];

    protected function decks() : BelongsToMany
    {
        return $this->belongsToMany(Deck::class, 'deck_cards')->using(DeckCard::class);
    }
}
