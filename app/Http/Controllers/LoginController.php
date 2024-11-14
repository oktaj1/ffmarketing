<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in using Laravel's Auth
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // After successful login, regenerate session ID for security
            $request->session()->regenerate();

            // You can return a redirect or a response here
            return redirect()->route('dashboard');
        }

        // If authentication fails, send an error back
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
}

