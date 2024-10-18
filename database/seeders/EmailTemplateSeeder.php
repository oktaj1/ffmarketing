<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;
use App\Models\Campaign;
use Illuminate\Support\Carbon;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // First ensure we have a default campaign
        $campaign = Campaign::first();
        
        if (!$campaign) {
            $campaign = Campaign::create([
                'name' => 'Default Campaign',
                'type' => 'general',
                'start_date' => $now,  // Added start_date using current timestamp
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        EmailTemplate::create([
            'name' => 'Welcome Template',
            'content' => 'Dear user, welcome to our platform. We are excited to have you!',
            'campaign_id' => $campaign->id,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        EmailTemplate::create([
            'name' => 'Promotion Template',
            'content' => 'Check out our latest promotions. Dont miss out on these deals!',
            'campaign_id' => $campaign->id,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}