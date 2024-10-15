<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subscribers'; // Adjust table name if different

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'channel', // assuming subscribers are linked to channels
        'phone_number',
        'address',
        'prompt',
        'avatar_image',
    ];
}
