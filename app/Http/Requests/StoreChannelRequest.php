<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChannelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|boolean',
            'sms' => 'required|boolean',
            'social_media' => 'required|boolean',
            'source' => 'required|string|max:255',
        ];
    }
}