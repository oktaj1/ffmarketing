<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Channel;
use App\Models\Campaign;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CampaignResource;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with(['channels', 'emailTemplate'])->get();
        $channels = Channel::all();  // Add this line to get all channels
        $emailTemplates = EmailTemplate::all();  // Add this if you need email templates

        return Inertia::render('Campaigns/Index', [
            'campaigns' => CampaignResource::collection($campaigns)->toArray(request()),
            'channels' => $channels,  // Pass channels to the view
            'emailTemplates' => $emailTemplates,  // Pass email templates if needed
        ]);
    }

    public function store(StoreCampaignRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validated();
            $channels = $validated['channels'] ?? [];
            unset($validated['channels']);
            
            Log::info('Creating campaign with data:', $validated);
            
            $campaign = Campaign::create($validated);
            
            if (!empty($channels)) {
                $campaign->channels()->attach($channels);
            }
            
            DB::commit();
            
            return redirect()->route('campaigns.index')
                           ->with('success', 'Campaign created successfully.');
                           
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create campaign: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Failed to create campaign: ' . $e->getMessage());
        }
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        try {
            DB::beginTransaction();
            
            $campaign = Campaign::where('ulid', $campaign)->firstOrFail();
            $validated = $request->validated();
            
            $channels = $validated['channels'] ?? [];
            unset($validated['channels']);
            
            Log::info('Updating campaign with data:', $validated);
            
            $campaign->update($validated);
            $campaign->channels()->sync($channels);
            
            DB::commit();
            
            return redirect()->route('campaigns.index')
                           ->with('success', 'Campaign updated successfully.');
                           
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update campaign: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Failed to update campaign: ' . $e->getMessage());
        }
    }
    public function destroy(Campaign $campaign): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Detach related channels before deleting the campaign
            $campaign->channels()->detach();
            $campaign->delete();
            
            DB::commit();
            
            return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete campaign: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Failed to delete campaign: ' . $e->getMessage());
        }
    }
    

}