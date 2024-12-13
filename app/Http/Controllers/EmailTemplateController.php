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
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'style' => 'required|string|in:style1,style2,style3',
            'content' => 'required|string',
        ]);

        // Create and save the new email template to the database
        $emailTemplate = EmailTemplate::create([
            'name' => $validated['name'],
            'style' => $validated['style'],
            'content' => $validated['content'],
            'image_path' => null,  // Optionally, add image path logic here
        ]);

        // Return a response indicating success
        return response()->json(['message' => 'Email template created successfully', 'data' => $emailTemplate], 201);
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
    

// In EmailTemplateController.php
public function saveBladeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'style' => 'required|string|in:style1,style2,style3', // Styles that you allow
        ]);

        $emailTemplate = EmailTemplate::create([
            'name' => $validated['name'],
            'content' => $validated['content'],
            'style' => $validated['style'],
        ]);

        return response()->json([
            'message' => 'Template saved successfully!',
            'emailTemplate' => $emailTemplate
        ]);
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
