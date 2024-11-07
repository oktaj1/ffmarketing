<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:email,sms',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:active,paused,completed',
            'email_template_id' => 'nullable|exists:email_templates,ulid',
            'channels' => 'array',
            'channels.*' => 'exists:channels,ulid',
        ];
    }
    
}