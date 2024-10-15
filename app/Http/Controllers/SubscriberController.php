<?php

namespace App\Http\Controllers;

use App\Models\Subscriber; // Import your model
use Inertia\Inertia;

class SubscriberController extends Controller
{
    public function index()
    {
        // Fetch subscribers from the database
        $subscribers = Subscriber::all();

        // Return the Inertia view with subscribers
        return Inertia::render('Subscribers/Index', [
            'subscribers' => $subscribers,
        ]);
    }
}
