<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory, HasUlid;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'ulid';
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'campaign_channel', 'campaign_ulid', 'channel_ulid');
    }

    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}