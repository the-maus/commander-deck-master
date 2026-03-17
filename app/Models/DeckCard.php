<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DeckCard extends Pivot
{
    protected $fillable = [
        'deck_id',
        'card_id',
        'quantity',
        'image_url',
        'extra_image', // for double faced cards for example
        'printed_name', // for cards in other languages
    ];
}
