<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Channel;
use App\Http\Resources\ChannelResource;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::withCount('subscribers')->get();
    
        return Inertia::render('Channels', [
            'channels' => ChannelResource::collection($channels),
        ]);
    }

    public function create()
    {
        return Inertia::render('Channels/Create');
    }

    public function store(StoreChannelRequest $request)
    {
        $validated = $request->validated();
        Channel::create($validated);

        return redirect()->route('channels.index')->with('success', 'Channel created successfully.');
    }

    public function edit($ulid)
    {
        $channel = Channel::where('ulid', $ulid)->firstOrFail();

        return Inertia::render('Channels/Edit', [
            'channel' => $channel,
        ]);
    }

    public function update(UpdateChannelRequest $request, $ulid)
    {
        $channel = Channel::where('ulid', $ulid)->firstOrFail();
        $data = $request->validated();

        $channel->update($data);

        return redirect()->route('channels.index')->with('success', 'Channel updated successfully.');
    }

    public function destroy($ulid)
    {
        $channel = Channel::where('ulid', $ulid)->firstOrFail();
        $channel->campaign()->detach();
        $channel->delete();
    
        return redirect()->route('channels.index')->with('success', 'Channel deleted successfully.');
    }
}
