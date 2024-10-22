<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscriber;
use App\Models\Channel;
use Illuminate\Support\Str;

class SubscriberSeeder extends Seeder
{
    public function run()
    {
        // Define an array of channels and their associated subscriber data
        $subscribers = [
            [
                'channel_source' => '55 Studio website',
                'first_name' => 'John Doe',
                'email' => 'john@example.com',
            ],
            [
                'channel_source' => '55 Studio AI',
                'first_name' => 'Jane Smith',
                'email' => 'jane@example.com',
            ],
            [
                'channel_source' => '55 Studio Contact Form',
                'first_name' => 'Alice Johnson',
                'email' => 'alice@example.com',
            ],
            [
                'channel_source' => '55 Studio Subscription',
                'first_name' => 'Bob Brown',
                'email' => 'bob@example.com',
            ],
        ];

        foreach ($subscribers as $data) {
            $channel = Channel::where('source', $data['channel_source'])->first();

            if ($channel) {
                Subscriber::create([
                    'id' => (string) Str::ulid(), // Generate ulid for 'id' field
                    'first_name' => $data['first_name'],
                    'email' => $data['email'],
                    'channel_id' => $channel->id,
                ]);
            }
        }
    }
}
