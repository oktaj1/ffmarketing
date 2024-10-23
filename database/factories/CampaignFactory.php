<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
    'ulid' => (string) Str::ulid(),
    'name' => $this->faker->name,
    'description' => $this->faker->paragraph,
    'type' => $this->faker->randomElement(['email', 'sms']),
    'start_date' => $this->faker->date(),
    'end_date' => $this->faker->date(),
    'status' => $this->faker->randomElement(['active', 'paused', 'completed']),
    'target_audience' => $this->faker->sentence,
    'audience_size' => $this->faker->numberBetween(1000, 5000),
    'lead_source' => $this->faker->word,
   ];         
}
}
