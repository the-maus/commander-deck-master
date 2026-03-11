<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function deckCards()
    {
        return $this->hasMany(DeckCard::class);
    }
}
