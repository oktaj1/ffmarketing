<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::all();  // or whatever logic you're using
        return Inertia::render('EmailTemplates/Index', [
            'emailTemplates' => $emailTemplates,  // This is the key that should be received in Vue
            'errors' => session('errors') ?? [],  // optional, if you have errors
        ]);
    }
        
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string|max:500',
        ]);
    
        $template = EmailTemplate::create([
            'name' => $request->name,
            'content' => $request->description,
        ]);
    
        return redirect()->route('email-templates.index');  // Redirect back or send a success message
    }
        
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string|max:500',
        ]);
    
        $template = EmailTemplate::findOrFail($id);
        $template->update([
            'name' => $request->name,
            'content' => $request->description,
        ]);
    
        return redirect()->route('email-templates.index');  // Redirect back or send a success message
    }

    
    public function destroy($id)
    {
        // Find the template
        $template = EmailTemplate::findOrFail($id);
    
        // Check if any campaigns are using this template
        $campaigns = Campaign::where('email_template_id', $id)->get();
    
        // Optionally, delete related campaigns first
        foreach ($campaigns as $campaign) {
            $campaign->delete(); // Delete or update campaigns as needed
        }
    
        // Now delete the template
        $template->delete();
    
        return redirect()->route('email-templates.index');  // Or return success response
    }
    

}
