<?php

namespace App\Http\Controllers;

use App\Models\DataModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class DataController extends Controller
{
    public function register(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'email' => 'required|email|unique:data',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'channel' => 'required|string|max:255',
            'prompt' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        // Create a new DataModel instance
        DataModel::create([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'channel' => $validated['channel'],
            'prompt' => $validated['prompt'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make('temporary_password'), // Handle password as needed
        ]);

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard'); // Ensure you have a Dashboard.vue
    }
}
