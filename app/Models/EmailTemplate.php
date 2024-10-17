<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'subject', 'body'];

    // You can add any relationships or custom logic here
}
