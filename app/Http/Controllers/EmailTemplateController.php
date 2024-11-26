<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\File;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::all(); // Retrieve all email templates
        return Inertia::render('EmailTemplates/Index', [
            'emailTemplates' => $emailTemplates, // Pass the templates to the frontend
        ]);
    }

    public function create()
    {
        return Inertia::render('EmailTemplates/Create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'html_content' => 'required|string',
            'style' => 'required|string|in:style1,style2,style3', // Validate style selection
        ]);

        // Create the email template in the database
        EmailTemplate::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null, // Handle nullable description
            'html_content' => $validated['html_content'],
            'style' => $validated['style'],
        ]);

        // Redirect back to the email templates index
        return redirect()->route('emailTemplates.index')->with('success', 'Email Template Created Successfully.');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id); // Find the template or throw 404
        return Inertia::render('EmailTemplates/Edit', [
            'template' => $template,
        ]);
    }

    public function loadBladeCode(Request $request)
    {
        $style = $request->input('style');
    
        switch ($style) {
            case 'style1':
                return response()->json([
                    'blade_code' => view('email_templates.style1')->render(),
                    'preview_html' => view('email_templates.style1')->render()
                ]);
            case 'style2':
                return response()->json([
                    'blade_code' => view('email_templates.style2')->render(),
                    'preview_html' => view('email_templates.style2')->render()
                ]);
            case 'style3':
                return response()->json([
                    'blade_code' => view('email_templates.style3')->render(),
                    'preview_html' => view('email_templates.style3')->render()
                ]);
            default:
                return response()->json(['error' => 'Style not found'], 404);
        }
    }
    

    public function saveBladeTemplate(Request $request)
    {
        $style = $request->input('style');
        $content = $request->input('content');
    
        $templatePath = resource_path("views/email_templates/{$style}.blade.php");
    
        try {
            File::put($templatePath, $content);
    
            return response()->json([
                'message' => 'Template saved successfully',
                'path' => $templatePath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to save template',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function previewTemplate($style)
    {
        switch ($style) {
            case 'style1':
                return view('email_templates.style1');
            case 'style2':
                return view('email_templates.style2');
            case 'style3':
                return view('email_templates.style3');
            default:
                abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'html_content' => 'required|string',
            'style' => 'required|string|in:style1,style2,style3', // Validate style selection
        ]);

        // Update the template in the database
        $template->update($validated);

        return redirect()->route('emailTemplates.index')->with('success', 'Email Template Updated Successfully.');
    }

    public function show($id)
    {
        $template = EmailTemplate::findOrFail($id); // Find the template or throw 404
        return Inertia::render('EmailTemplates/Show', [
            'template' => $template,
        ]);
    }

    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id); // Find the template or throw 404
        $template->delete();

        return redirect()->route('emailTemplates.index')->with('success', 'Email Template Deleted Successfully.');
    }
}
