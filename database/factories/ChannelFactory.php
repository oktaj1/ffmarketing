<?php

namespace Database\Factories;

use App\Models\Channel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    protected $model = Channel::class; // Link the factory to the Channel model

    public function definition(): array
    {
        return [
            'ulid' => (string) Str::ulid(),
            'email' => $this->faker->boolean,
            'sms' => $this->faker->boolean,
            'social_media' => $this->faker->boolean,
            'source' => $this->faker->word,
        ];
    }
}

