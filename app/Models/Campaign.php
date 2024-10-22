<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];

    // Define the relationship with EmailTemplate
    public function emailTemplates()
    
    {
        return $this->hasMany(EmailTemplate::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            $subscriber->id = (string) Str::ulid(); // Generate ULID
        });
    }
    // Define any other relationships as needed
    public function channels()
    {
        return $this->belongsToMany(Channel::class)->withTimestamps();
    }
}
