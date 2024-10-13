<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', function () {
    return Inertia::render('Register');
})->name('register.show');

Route::post('/register', [RegisterController::class, 'register'])->name('register');



// use Inertia\Inertia;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DataController;

// Route::get('/', function () {
//     return Inertia::render('Dashboard', [

//         'user' => Auth::user(),
//     ]);
// });

// Route::post('/data', [DataController::class, 'store']);


// Route::get('/register', function () {

    //     return Inertia::render('Register');
    // })->name('register');
    
    // Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    
