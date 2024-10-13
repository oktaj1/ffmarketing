<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUlid;

class DataModel extends Model
{
    use HasUlid;

    // Define the table name if necessary
    protected $table = 'data';

    // Define which fields are fillable
    protected $guarded = [
        // 'ulid',
        // 'email',
        // 'first_name',
        // 'last_name',
        // 'channel',
        // 'prompt',
        // 'phone_number',
    ];
}
