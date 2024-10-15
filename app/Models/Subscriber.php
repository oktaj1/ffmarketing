<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'channel_id', // Add this to the fillable array
        'phone_number',
        'address',
        'prompt',
        'avatar_image',
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
