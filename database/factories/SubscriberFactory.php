<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'channel_id' => Channel::inRandomOrder()->first()->id ?? Channel::factory(),
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'prompt' => $this->faker->sentence,
            'avatar_image' => null,
        ];
    }
}