<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Channel;
use App\Models\Campaign;
use App\Models\EmailTemplate;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::all(); // Fetch your campaigns
        $emailTemplates = EmailTemplate::all(); // Fetch your email templates
        $channels = Channel::all(); // Fetch your channels
    
        return Inertia::render('Campaigns/Index', [ // Make sure 'Index' is capitalized
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
        $data = $request->validated();
        $channels = $data['channels'] ?? [];
        unset($data['channels']);
    
        $campaign = Campaign::create($data);
        $campaign->channels()->sync($channels);
    
        return redirect()->route('campaigns.index');
    }

    public function edit(Campaign $campaign) // Model binding for Campaign
    {
        $emailTemplates = EmailTemplate::all();
        $channels = Channel::all();
    
        return Inertia::render('Campaigns/Edit', [
            'campaign' => $campaign,
            'emailTemplates' => $emailTemplates,
            'channels' => $channels,
        ]);
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $data = $request->validated();
        $channels = $data['channels'] ?? [];
        unset($data['channels']);
    
        $campaign->update($data);
        $campaign->channels()->sync($channels);
    
        return redirect()->route('campaigns.index');
    }

    public function destroy(Campaign $campaign) // Model binding for Campaign
    {
        $campaign->delete();

        return redirect()->route('campaigns.index');
    }
}
