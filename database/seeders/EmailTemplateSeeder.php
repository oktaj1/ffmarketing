<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Ensure we have a default campaign
        $campaign = Campaign::first();

        if (!$campaign) {
            $campaign = Campaign::create([
                'id' => (string) Str::ulid(), // Generate ulid for the campaign
                'name' => 'Default Campaign',
                'type' => 'general',
                'start_date' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Create email templates with ulids for their IDs
        EmailTemplate::create([
            'id' => (string) Str::ulid(), // Generate ulid for the email template
            'name' => 'Welcome Template',
            'content' => 'Dear user, welcome to our platform. We are excited to have you!',
            'campaign_id' => $campaign->id, // Use ulid of the campaign
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        EmailTemplate::create([
            'id' => (string) Str::ulid(), // Generate ulid for the email template
            'name' => 'Promotion Template',
            'content' => 'Check out our latest promotions. Don’t miss out on these deals!',
            'campaign_id' => $campaign->id,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
