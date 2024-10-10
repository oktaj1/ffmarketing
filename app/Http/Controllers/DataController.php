<?php


namespace App\Http\Controllers;

use App\Models\DataModel;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'channel' => 'required|string|max:255',
            'prompt' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
        ]);

        // Store the validated data into the `data` table
        $data = DataModel::create([
            'ulid' => $request->ulid,  // Ensure ULID is nullable if not provided
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'channel' => $request->channel,
            'prompt' => $request->prompt,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json(['success' => true, 'data' => $data], 201);
    }
}
