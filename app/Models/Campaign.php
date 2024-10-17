<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'start_date',
        'end_date',
        'status',
        'email_template_id', // New field for the selected email template
        'target_audience',
        'audience_size',
        'lead_source',
        'channels',
        
    ];

    protected $casts = [
        'channels' => 'array',
    ];

    // Relationship with EmailTemplate
    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}
