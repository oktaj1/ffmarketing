<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Channel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriberController extends Controller
{
    public function index()
    {
        // Fetch subscribers with their corresponding channels
        $subscribers = Subscriber::with('channel')->get();
    
        // Fetch all channels
        $channels = Channel::all();
    
        // Return the Inertia view with subscribers and channels
        return Inertia::render('Subscribers/Index', [
            'subscribers' => $subscribers,
            'channels' => $channels, // Add channels to the view
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'channel_id' => 'required|exists:channels,id', // Validate the channel exists
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'prompt' => 'nullable|string',
            'avatar_image' => 'nullable|image',
        ]);
    
        // Create the subscriber
        $subscriber = Subscriber::create($validated);
    
        // Increment the subscriber count for the related channel
        $channel = Channel::find($validated['channel_id']);
        $channel->increment('subscriber_count');
    
        return redirect()->route('subscribers.index');
    }

    public function destroy($id)
    {
        // Find the subscriber by ID
        $subscriber = Subscriber::findOrFail($id);

        // Get the channel_id before deleting the subscriber
        $channelId = $subscriber->channel_id;

        // Delete the subscriber
        $subscriber->delete();

        // Decrement the subscriber count for the related channel
        if ($channelId) {
            $channel = Channel::find($channelId);
            $channel->decrement('subscriber_count');
        }

        return redirect()->route('subscribers.index');
    }
}
