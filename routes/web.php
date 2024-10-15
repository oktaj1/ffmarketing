<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\SettingsController;

Route::get('/', function () {
    return Inertia::render('Welcome'); // This points to your Welcome.vue
})->name('welcome');

// Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard'); // Your dashboard Vue component
    })->name('dashboard');
    
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::post('/subscribers', [SubscriberController::class, 'store'])->name('subscribers.store');
    Route::delete('/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    // Route::get('/channels', [ChannelController::class, 'index'])->name('channels.index');
    Route::resource('campaigns', CampaignController::class);
    Route::resource('channels', ChannelController::class);

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/'); // Redirect to the welcome page after logout
    })->name('logout');
// });
