<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;
    use HasUlid;  // Add this
    use SoftDeletes;  // You have this in your migration, so add this too

    protected $guarded = [];

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_channel', 'channel_ulid', 'campaign_ulid');
    }
}