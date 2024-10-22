<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Channel extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($channel) {
            $channel->id = (string) Str::ulid(); // Generate ulid
        });
    }

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
