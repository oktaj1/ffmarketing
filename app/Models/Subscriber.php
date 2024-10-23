<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Traits\HasUlid;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes , HasUlid;

    protected $guarded = [];


    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}