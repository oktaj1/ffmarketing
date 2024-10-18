<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Channel extends Model
{
    protected $fillable = [
        'email',
        'sms',
        'social_media',
        'source'
    ];

    protected $appends = ['subscriber_count'];

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class);
    }

    public function getSubscriberCountAttribute()
    {
        $cacheKey = "channel.{$this->id}.subscriber_count";
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () {
            return $this->subscribers()->count();
        });
    }
}