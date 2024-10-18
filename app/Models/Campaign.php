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
        'email_template_id',
        'target_audience',
        'audience_size',
        'lead_source'
    ];

    public function channels()
    {
        return $this->belongsToMany(Channel::class)
            ->withTimestamps();
    }

    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}