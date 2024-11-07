<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCampaignRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:email,sms',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,paused,completed',
            'email_template_id' => 'nullable|exists:email_templates,ulid',
            'channels' => 'nullable|array',
            'channels.*' => 'exists:channels,ulid',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The campaign name is required.',
            'name.max' => 'The campaign name must not exceed 255 characters.',
            'description.max' => 'The description must not exceed 1000 characters.',
            'type.required' => 'The campaign type is required.',
            'type.in' => 'The selected type is invalid.',
            'start_date.required' => 'The start date is required.',
            'start_date.before_or_equal' => 'The start date must be before or equal to the end date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'status.required' => 'The campaign status is required.',
            'status.in' => 'The selected status is invalid.',
            'email_template_id.exists' => 'The selected email template does not exist.',
            'channels.array' => 'Channels must be an array of valid channel ULIDs.',
            'channels.*.exists' => 'One or more selected channels are invalid.',
        ];
    }
}