<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,paused,completed',
            'target_audience' => 'nullable|string',
            'audience_size' => 'nullable|integer',
            'lead_source' => 'nullable|string',
            'channels' => 'array', // Add this line to validate channels array
            'channels.*' => 'exists:channels,id' // Validate each channel ID
        ];
    }
}