<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'channel' => 'required|string|max:255',
            'prompt' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'channel' => $validated['channel'],
            'prompt' => $validated['prompt'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make('temporary_password'), // You might want to handle this differently
        ]);

        // Handle post-registration logic (e.g., login, send email, etc.)

        return redirect()->route('dashboard');
    }
}