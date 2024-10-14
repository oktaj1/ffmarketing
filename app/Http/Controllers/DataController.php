<?php

namespace App\Http\Controllers;

use App\Models\DataModel; // Use your DataModel
use Illuminate\Http\Request;

class DataController extends Controller
{
    // Store the data submitted from the form
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'email' => 'required|email|unique:data',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'channel' => 'required|string|max:255',
            'prompt' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        // Insert the validated data into the 'data' table
        $data = DataModel::create([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'channel' => $validated['channel'],
            'prompt' => $validated['prompt'],
            'phone_number' => $validated['phone_number'],
        ]);

        // Redirect or return a response
        return redirect()->route('dashboard')->with('success', 'Data added successfully');
    }
}
