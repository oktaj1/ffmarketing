<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;




class Channel extends Model
{
    protected $fillable = ['email', 'sms', 'social_media', 'source'];
}
