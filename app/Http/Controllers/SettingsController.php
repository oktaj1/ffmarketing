<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show()
    {
        // Assuming you're fetching user-specific settings
        // return response()->json(['email' => auth()->user()->email]);
    }

    public function update(Request $request)
    {
        // Assuming you're updating user-specific settings
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|min:6',
        ]);

        // $user = auth()->user();
        // $user->email = $request->input('email');
        
        // if ($request->filled('password')) {
        //     $user->password = bcrypt($request->input('password'));
        // }

        // $user->save();

        // return response()->json($user);
    }
}
