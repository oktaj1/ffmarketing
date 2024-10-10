<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataModel extends Model
{
    use SoftDeletes;

    protected $table = 'data';  // Explicitly define the table name

    protected $fillable = [
        'ulid',
        'email',
        'first_name',
        'last_name',
        'channel',
        'prompt',
        'phone_number',
    ];
}
