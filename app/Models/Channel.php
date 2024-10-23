<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model 
{
    use HasUlid;
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];



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
