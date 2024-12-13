<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\EmailTemplateController;


Route::post('/subscribers', [SubscriberController::class, 'store'])->name('subscribers.store');
Route::get('blade-code', [EmailTemplateController::class, 'loadBladeCode']);
// Route::post('/save-blade-template', [EmailTemplateController::class, 'saveBladeTemplate']);
// Route::post('/api/save-blade-template', [EmailTemplateController::class, 'saveBladeTemplate']);
Route::post('/save-blade-template', [EmailTemplateController::class, 'saveBladeTemplate']);