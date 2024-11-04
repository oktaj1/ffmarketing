<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Channel;
use App\Models\Campaign;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CampaignResource;
use App\Http\Requests\EditCampaignRequest;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with(['channels', 'emailTemplate'])->get();
        $channels = Channel::all();
        $emailTemplates = EmailTemplate::all();

        return Inertia::render('Campaigns/Index', [
            'campaigns' => CampaignResource::collection($campaigns)->toArray(request()),
            'channels' => $channels,
            'emailTemplates' => $emailTemplates,
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


    
    public function update(UpdateCampaignRequest $request, $ulid)
    {
        try {
            DB::beginTransaction();
    
            $campaign = Campaign::where('ulid', $ulid)->firstOrFail();
            $validated = $request->validated();
            
            // Handle channels separately
            $channels = $validated['channels'] ?? [];
            unset($validated['channels']);
            
            // Format dates consistently
            if (isset($validated['start_date'])) {
                $validated['start_date'] = Carbon::parse($validated['start_date'])->format('Y-m-d');
            }
            if (isset($validated['end_date'])) {
                $validated['end_date'] = Carbon::parse($validated['end_date'])->format('Y-m-d');
            }
    
            // Update campaign
            $campaign->update($validated);
            
            // Sync channels
            $campaign->channels()->sync($channels);
    
            DB::commit();
    
            return redirect()->route('campaigns.index')
                            ->with('success', 'Campaign updated successfully.');
                            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update campaign:', [
                'error' => $e->getMessage(),
                'campaign_id' => $ulid,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                            ->with('error', 'Failed to update campaign. Please try again.');
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