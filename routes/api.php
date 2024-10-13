<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::post('/data', [DataController::class, 'store']);
Route::post('/data/store', [DataController::class, 'store']);
