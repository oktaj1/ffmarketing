<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasUlid;
    use HasFactory;
    protected $guarded = [];

    // Define the relationship with EmailTemplate
    public function emailTemplates()
    
    {
        return $this->hasMany(EmailTemplate::class);
    }

    // Define any other relationships as needed
    public function channels()
    {
        return $this->belongsToMany(Channel::class)->withTimestamps();
    }
}
