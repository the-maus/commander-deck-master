<?php

use App\Http\Controllers\CardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/cards/search', [CardController::class, 'search'])->name('cards_search');
