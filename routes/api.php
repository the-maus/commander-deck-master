<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\DeckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Cards
Route::get('/cards/search', [CardController::class, 'search'])->name('cards_search');

// Decks
Route::post('/decks', [DeckController::class, 'create'])->name('decks_create');
