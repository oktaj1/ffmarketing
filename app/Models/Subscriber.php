<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    // Allow mass assignment on all fields
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            $subscriber->id = (string) Str::ulid(); // Generate ULID
        });
    }

    // Define the relationship to the Channel model
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
