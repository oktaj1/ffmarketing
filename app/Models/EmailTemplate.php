<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $guarded = [];

    // Define the relationship with Campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
