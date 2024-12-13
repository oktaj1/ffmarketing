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

    // Subscribers Routes
    Route::resource('subscribers', SubscriberController::class);

    // Campaigns Routes
    Route::resource('campaigns', CampaignController::class);

    // Channels Routes
    Route::resource('channels', ChannelController::class);

    // Settings Route
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');

    // Logout Route
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login'); // Redirect to the login page after logout
    })->name('logout');

    // Email Templates Routes
    Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('emailTemplates.index');
    Route::get('email-templates/create', [EmailTemplateController::class, 'create'])->name('emailTemplates.create');
    Route::post('email-templates', [EmailTemplateController::class, 'store'])->name('emailTemplates.store');
    Route::get('email-templates/{id}/edit', [EmailTemplateController::class, 'edit'])->name('emailTemplates.edit');
    Route::get('email-templates/{id}', [EmailTemplateController::class, 'show'])->name('emailTemplates.show');
    Route::put('email-templates/{id}', [EmailTemplateController::class, 'update'])->name('emailTemplates.update');
    Route::get('/api/blade-code', [EmailTemplateController::class, 'loadBladeCode']);
    Route::get('/preview/{style}', [EmailTemplateController::class, 'previewTemplate']);
    Route::post('email-templates', [EmailTemplateController::class, 'store']);
    Route::post('/save-blade-template', [EmailTemplateController::class, 'saveBladeTemplate']);
    Route::delete('email-templates/{id}', [EmailTemplateController::class, 'destroy'])->name('emailTemplates.destroy');
});
