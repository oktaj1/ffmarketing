<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    protected $fillable = [
        'email',
        'sms',
        'social_media',
        'source',
        'subscriber_count',
    ];

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class);
    }
}
