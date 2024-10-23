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

    protected $guarded = []; // Allow mass assignment for all fields

    // One campaign is associated with one email template
    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    // Many-to-many relationship with channels
    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'campaign_channel');
    }
}
