<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmailTemplateController;

// Public Routes
Route::get('/', function () {
    return Inertia::render('Welcome'); // Welcome.vue
})->name('welcome');

// Guest-only Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return Inertia::render('Auth/Register'); // Auth/Register.vue
    })->name('register.page');

    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', function () {
        return Inertia::render('Login'); // Login.vue
    })->name('login.page');

    Route::post('/login', [LoginController::class, '__invoke'])->name('login');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard'); // Dashboard.vue
    })->name('dashboard');

    Route::resource('subscribers', SubscriberController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::resource('channels', ChannelController::class);

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login'); // Redirect to the login page after logout
    })->name('logout');


    Route::resource('email-templates', EmailTemplateController::class);


});
