<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory, HasUlid;

    protected $guarded = [];


    public function channels() : BelongsToMany
    {
        return $this->belongsToMany(Channel::class);
    }

    public function emailTemplate() : BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}