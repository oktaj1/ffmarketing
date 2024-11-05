<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Channel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ChannelResource;
use App\Http\Requests\EditChannelRequest;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;

class ChannelController extends Controller
{
    public function index(): \Inertia\Response
    {
        $channels = Channel::withCount('subscribers')->get();
        return Inertia::render('Channels', [
            'channels' => ChannelResource::collection($channels)->response()->getData(true)['data'],
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Channels/Create');
    }

    public function store(StoreChannelRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        Channel::create($validated);

        return redirect()->route('channels.index')->with('success', 'Channel created successfully.');
    }

    public function update(UpdateChannelRequest $request, Channel $channel): \Illuminate\Http\RedirectResponse
    {
        $data = $request->all();
        $channel->update($data);
    
        return redirect()->route('channels.index')->with('success', 'Channel updated successfully.'); // Redirect to the index page with a success message
    }

    public function edit(EditChannelRequest $request, $ulid)
    {
        $channel = Channel::findOrFail($ulid);
        $channel->update($request->validated());
    
        return redirect()->route('channels.index')
                         ->with('success', 'Channel updated successfully.');
    }


    
    public function destroy(Channel $channel): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $channel->campaigns()->detach();
            $channel->delete();
            DB::commit();
    
            return response()->json(['success' => true, 'message' => 'Channel deleted successfully.']);
        } catch (Exception $e) {
            DB::rollBack();
    
            return response()->json(['success' => false, 'message' => 'Failed to delete channel: ' . $e->getMessage()], 500);
        }
    }
    
}