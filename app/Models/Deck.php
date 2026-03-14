<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = [
        'name',
        'commander_name',
        'commander_colors',
        'image_url',
        'art_crop'
    ];

    protected $casts = [
        'commander_colors' => 'array'
    ];

    public function deckCards()
    {
        return $this->hasMany(DeckCard::class);
    }
}
