<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'channel_id' => 'required|exists:channels,id',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'prompt' => 'nullable|string',
            'avatar_image' => 'nullable|image',
        ];
    }
}
