<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'campaigns'; // Adjust table name if needed

    protected $fillable = [
        'name',
        'channel_id', // assuming campaigns are tied to channels
        'description',
        'start_date',
        'end_date',
    ];
}
