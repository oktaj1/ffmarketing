<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Channel;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ChannelResource;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use Illuminate\Http\JsonResponse;

class ChannelController extends Controller
{
public function index()
{
    $channels = Channel::withCount('subscribers')->get();

    return Inertia::render('Channels', [
        'channels' => ChannelResource::collection($channels)->response()->getData(true)['data'],
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

    public function destroy(Channel $channel)
    {
        DB::beginTransaction();
        try{
            $channel->campaigns()->detach();
            $channel->delete();
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            return JsonResponse::error($e->getMessage());
        }

        return redirect()->route('channels.index')->with('success', 'Channel deleted successfully.');
    }
}
