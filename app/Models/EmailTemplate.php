<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasUlid;
    use HasFactory;
    protected $guarded = [];


    // Define the relationship with Campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
