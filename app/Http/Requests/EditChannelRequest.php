<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditChannelRequest extends FormRequest
{
    public function authorize()
    {
        // Authorize the request, or add more specific logic if needed
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'boolean',
            'sms' => 'boolean',
            'social_media' => 'boolean',
            'source' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'source.required' => 'The source field is required.',
            'source.max' => 'The source may not exceed 255 characters.',
        ];
    }
}
