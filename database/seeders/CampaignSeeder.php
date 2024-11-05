<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\Channel;

class CampaignSeeder extends Seeder
{
    public function run()
    {
        // Create campaigns using the CampaignFactory
        $campaigns = Campaign::factory()->count(4)->create(); // Adjust the count as needed

        // Attach random channels to each campaign
        foreach ($campaigns as $campaign) {
            // Attach 1 to 3 random channels to each campaign
            $channels = Channel::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $campaign->channels()->attach($channels);
        }
    }
}

