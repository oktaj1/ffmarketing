<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Inertia\Inertia;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::withCount('subscribers')->get();
        return Inertia::render('Channels', ['channels' => $channels]);
    }

    public function store(StoreChannelRequest $request)
    {
        $validated = $request->validated();
        Channel::create($validated);
        return redirect()->route('channels.index');
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $validated = $request->validated();
        $channel->update($validated);
        return redirect()->route('channels.index');
    }

    public function destroy(Channel $channel)
    {
        $channel->delete();
        return redirect()->route('channels.index');
    }
}