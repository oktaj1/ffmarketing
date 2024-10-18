<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Channel;
use Inertia\Inertia;
use App\Http\Requests\StoreSubscriberRequest;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::with('channel')->get();
        $channels = Channel::withCount('subscribers')->get();
    
        return Inertia::render('Subscribers/Index', [
            'subscribers' => $subscribers,
            'channels' => $channels,
        ]);
    }

    public function store(StoreSubscriberRequest $request)
    {
        $validated = $request->validated();
        $subscriber = Subscriber::create($validated);
        
        return redirect()->route('subscribers.index');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('subscribers.index');
    }
}