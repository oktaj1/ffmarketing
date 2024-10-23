<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Log; // Import Log facade
use App\Models\Channel;
use App\Models\Campaign;
use App\Models\EmailTemplate;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('channels')->get();
        $emailTemplates = EmailTemplate::all();
        $channels = Channel::all();
    
        return Inertia::render('Campaigns/Index', [
            'campaigns' => $campaigns,
            'emailTemplates' => $emailTemplates,
            'channels' => $channels,
        ]);
    }
    
    public function create()
    {
        $emailTemplates = EmailTemplate::all();
        $channels = Channel::all();

        return Inertia::render('Campaigns/Create', [
            'emailTemplates' => $emailTemplates,
            'channels' => $channels,
        ]);
    }

    public function store(StoreCampaignRequest $request)
    {
        // Get the validated data
        $validated = $request->validated(); 
    
        // Remove the 'channels' key from the validated data because we don't store it in the campaigns table
        $channels = $validated['channels'] ?? []; // Store channels separately
        unset($validated['channels']); // Remove channels from the main data array
    
        // Log the validated data for debugging
        Log::info('Validated data:', $validated);
    
        // Create the campaign with the remaining validated data
        $campaign = Campaign::create($validated);
    
        // Attach the selected channels to the campaign (using the pivot table)
        if (!empty($channels)) {
            $campaign->channels()->attach($channels);
        }
    
        // Redirect with success message
        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
    }
    

    public function edit($ulid)
    {
        $campaign = Campaign::where('ulid', $ulid)->firstOrFail();
        $emailTemplates = EmailTemplate::all();
        $channels = Channel::all();
    
        return Inertia::render('Campaigns/Edit', [
            'campaign' => $campaign,
            'emailTemplates' => $emailTemplates,
            'channels' => $channels,
        ]);
    }
    
    public function update(UpdateCampaignRequest $request, $ulid)
    {
        $campaign = Campaign::where('ulid', $ulid)->firstOrFail();
        $data = $request->validated();
        $channels = $data['channels'] ?? []; // Make sure this is an array
        unset($data['channels']);
    
        $campaign->update($data);
        $campaign->channels()->sync($channels);
    
        return redirect()->route('campaigns.index');
    }
    
    public function destroy($ulid)
    {
        $campaign = Campaign::where('ulid', $ulid)->firstOrFail();
        
        $campaign->channels()->detach(); // Detach the related channels
        $campaign->delete(); // Delete the campaign
        
        return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully.');
    }
    
}
