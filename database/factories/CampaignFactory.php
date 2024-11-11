<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\EmailTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    public function definition(): array
    {
        return [
            'ulid' => (string) Str::ulid(),
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['email', 'sms']),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'email_template_id' => EmailTemplate::factory(),
            'status' => $this->faker->randomElement(['active', 'paused', 'completed']),
            'target_audience' => $this->faker->sentence,
            'audience_size' => $this->faker->numberBetween(1000, 5000),
            'lead_source' => $this->faker->word,
        ];
    }
}