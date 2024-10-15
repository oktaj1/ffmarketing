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
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'boolean',
            'sms' => 'boolean',
            'social_media' => 'boolean',
            'source' => 'required|string|max:255',
        ]);

        Channel::create($validated); // Create a new channel
        return redirect()->route('channels.index');
    }

    public function update(Request $request, Channel $channel)
    {
        $validated = $request->validate([
            'email' => 'boolean',
            'sms' => 'boolean',
            'social_media' => 'boolean',
            'source' => 'required|string|max:255',
        ]);

        $channel->update($validated); // Update the existing channel
        return redirect()->route('channels.index');
    }

    public function destroy(Channel $channel)
    {
        $channel->delete(); // Delete the channel
        return redirect()->route('channels.index');
    }
}
