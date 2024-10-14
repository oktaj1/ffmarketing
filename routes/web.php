<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/register', function () {
    return Inertia::render('Register');
})->name('register.show');

// routes/web.php



Route::get('/dashboard', function () {
    return view('dashboard'); // Assuming your dashboard is located in 'resources/views/dashboard.blade.php'
})->name('dashboard');

// Register route for form submission
Route::post('/register', [DataController::class, 'store'])->name('register');




// Route::get('/register', [DataController::class, 'showRegisterForm'])->name('register.show');
// Route::post('/register', [DataController::class, 'register'])->name('register');
// Route::get('/dashboard', [DataController::class, 'dashboard'])->name('dashboard');