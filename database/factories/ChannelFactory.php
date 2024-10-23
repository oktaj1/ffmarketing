<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ulid' =>  (string) Str::ulid(), 
            'source' => $this->faker->name,
            'email' => $this->faker->boolean,
            'sms' => $this->faker->boolean,
            'social_media' => $this->faker->boolean,
        ];
    }
}
