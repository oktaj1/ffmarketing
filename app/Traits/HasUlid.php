<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUlid
{
    /**
     * Boot the trait. Attach to the model's creating event.
     */
    public static function bootHasUlid()
    {
        static::creating(function ($model) {
            // Only generate ULID if it's not already set.
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    /**
     * Retrieve the ULID column name.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'ulid';
    }
}
