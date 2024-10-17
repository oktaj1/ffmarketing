<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\EmailTemplate; // Import the EmailTemplate model
use Illuminate\Http\Request;
use Inertia\Inertia;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('emailTemplate')->get(); // Eager load email templates
        $emailTemplates = EmailTemplate::all(); // Fetch all available email templates for the dropdown

        return Inertia::render('Campaigns/Index', [
            'campaigns' => $campaigns,
            'emailTemplates' => $emailTemplates, // Pass email templates to the view
        ]);
    }

    public function create()
    {
        // This method might be unnecessary if you're handling creation in the Index view.
        $emailTemplates = EmailTemplate::all(); // Fetch all available email templates

        return Inertia::render('Campaigns/Create', [
            'emailTemplates' => $emailTemplates,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:active,paused,completed',
            'email_template_id' => 'nullable|exists:email_templates,id', // Validate template ID
            // Other fields...
        ]);

        Campaign::create($data); // Store campaign

        return redirect()->route('campaigns.index');
    }

    public function edit($id)
    {
        // This method might also be unnecessary if you're handling editing in the Index view.
        $campaign = Campaign::findOrFail($id);
        $emailTemplates = EmailTemplate::all(); // Fetch all email templates for editing

        return Inertia::render('Campaigns/Edit', [
            'campaign' => $campaign,
            'emailTemplates' => $emailTemplates,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:active,paused,completed',
            'email_template_id' => 'nullable|exists:email_templates,id',
            // Other fields...
        ]);

        $campaign = Campaign::findOrFail($id);
        $campaign->update($data);

        return redirect()->route('campaigns.index');
    }

    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return redirect()->route('campaigns.index');
    }
}
