<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Channel;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriberRequest;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query()->with('channel');
    
        if ($request->filled('channel_id')) {
            $query->where('channel_id', $request->channel_id);
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
    
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
    
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }
    
        $subscribers = $query->get();
    
        if ($request->wantsJson()) {
            return response()->json([
                'subscribers' => $subscribers,
                'channels' => Channel::all(),
            ]);
        }
    
        return inertia('Subscribers', [
            'subscribers' => $subscribers,
            'channels' => Channel::all(),
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