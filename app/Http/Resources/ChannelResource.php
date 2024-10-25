<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->ulid,
            'email' => $this->email,
            'sms' => $this->sms,
            'social_media' => $this->social_media,
            'source' => $this->source,
            'subscribers_count' => $this->subscribers_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}