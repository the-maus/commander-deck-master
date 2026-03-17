<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function cards() : BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'deck_cards')->using(DeckCard::class);
    }
}
