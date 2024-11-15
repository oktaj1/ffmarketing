<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplate extends Model
{
    use HasFactory;
    use HasUlid;
    protected $fillable = ['name', 'content'];

    public function campaign() : HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}