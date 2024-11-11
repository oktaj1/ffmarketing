<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;
class Setting extends Model
{
    use HasFactory , HasUlid;

    protected $table = 'settings';

    protected $guarded = [
        // 'user_id', // if user-specific
        // 'email',
        // 'password',
        // 'notifications_enabled',
        // 'language_preference',
    ];
}