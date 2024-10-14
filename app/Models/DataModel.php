<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataModel extends Model
{
    use HasFactory, SoftDeletes, HasUlid;

    // Specify the table if it's not the default 'datas'
    protected $table = 'data';

    // Define which columns can be mass-assigned
    protected $fillable = [
        'email', 'first_name', 'last_name', 'channel', 'prompt', 'phone_number',
    ];

    // Optionally, you can define any default values or additional methods here
}
