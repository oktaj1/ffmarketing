<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory, HasUlid;

    protected $fillable = [
        'name',
        'description',
        'type',
        'start_date',
        'end_date',
        'status',
        'email_template_id', // If applicable
    ];

    public function getRouteKeyName()
    {
        return 'ulid';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class);
    }

    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}
