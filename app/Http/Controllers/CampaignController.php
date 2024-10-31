<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Models\Channel;
use App\Models\Campaign;
use App\Models\EmailTemplate;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with(['channels', 'emailTemplate'])->get()
            ->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'ulid' => $campaign->ulid,
                    'name' => $campaign->name,
                    'description' => $campaign->description,
                    'type' => $campaign->type,
                    'start_date' => $campaign->start_date,
                    'end_date' => $campaign->end_date,
                    'status' => $campaign->status,
                    'channels' => $campaign->channels,
                    'email_template_id' => $campaign->email_template_id,
                ];
            });

        return Inertia::render('Campaigns/Index', [
            'campaigns' => $campaigns,
            'emailTemplates' => EmailTemplate::all(),
            'channels' => Channel::all(),
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

    public function destroy($ulid)
    {
        try {
            DB::beginTransaction();
            
            $campaign = Campaign::where('ulid', $ulid)->firstOrFail();
            
            // Delete related records first
            $campaign->channels()->detach();
            $campaign->delete();
            
            DB::commit();
            
            return redirect()->route('campaigns.index')
                           ->with('success', 'Campaign deleted successfully.');
                           
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete campaign: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Failed to delete campaign: ' . $e->getMessage());
        }
    }
}