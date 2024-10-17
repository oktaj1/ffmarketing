<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SubscriberController;

Route::post('/data', [DataController::class, 'store']);
Route::post('/data/store', [DataController::class, 'store']);


Route::post('/subscribers', [SubscriberController::class, 'store'])->name('subscribers.store');
