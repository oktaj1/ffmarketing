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
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['email', 'sms']),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'paused', 'completed']),
            'target_audience' => $this->faker->text(),
            'audience_size' => $this->faker->numberBetween(1, 10000),
            'lead_source' => $this->faker->word(),
            'channels' => json_encode([$this->faker->word(), $this->faker->word()]), // Fix: remove backticks
        ];
            
    }
}
