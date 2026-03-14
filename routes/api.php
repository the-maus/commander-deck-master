<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\DeckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Cards
Route::get('/cards/search', [CardController::class, 'search'])->name('cards_search');
Route::get('/cards/prints', [CardController::class, 'getCardPrints'])->name('cards_prints');

// Decks
Route::get('/decks', [DeckController::class, 'index'])->name('decks_index');
Route::post('/decks', [DeckController::class, 'create'])->name('decks_create');
Route::put('/decks/{id}', [DeckController::class, 'update'])->name('decks_update');
Route::get('/decks/{id}', [DeckController::class, 'show'])->name('decks_show');
Route::delete('/decks/{id}', [DeckController::class, 'delete'])->name('decks_delete');
