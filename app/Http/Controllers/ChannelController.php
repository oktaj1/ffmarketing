<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::all(); // Fetch all channels
        return Inertia::render('Channels', ['channels' => $channels]); // Pass channels to the view

        return Inertia::render('Subscribers/Index', [
            'subscribers' => $subscribers,
            'channels' => $channels,
        ]);
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'email' => 'required|boolean',
            'sms' => 'required|boolean',
            'social_media' => 'required|boolean',
            'source' => 'required|string|max:255',
        ]);

        // Create a new channel
        Channel::create($validated);

        return redirect()->route('channels.index');
    }

    public function update(Request $request, Channel $channel)
    {
        // Validate the incoming data for updating the channel
        $validated = $request->validate([
            'email' => 'required|boolean',
            'sms' => 'required|boolean',
            'social_media' => 'required|boolean',
            'source' => 'required|string|max:255',
        ]);

        // Update the channel with the validated data
        $channel->update($validated);

        return redirect()->route('channels.index');
    }

    public function destroy(Channel $channel)
    {
        // Delete the specified channel
        $channel->delete();

        return redirect()->route('channels.index');
    }
}
