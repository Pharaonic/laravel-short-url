<?php

use Illuminate\Support\Facades\Route;
use Pharaonic\Laravel\ShortURL\ShortURLController;

Route::get(config('Pharaonic.short-url.prefix', '') . '/{ShortURL}', ShortURLController::class . '@ShortURL')->middleware('web')->name('shortURL');
