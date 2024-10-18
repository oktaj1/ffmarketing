<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscriber;

class SubscriberSeeder extends Seeder
{
    public function run()
    {
        Subscriber::create([
            'first_name' => 'John Doe',
            'email' => 'john@example.com',

            'channel_id' => 1, // Adjust according to your channels
        ]);

        Subscriber::create([
            'first_name' => 'Jane Smith',
            'email' => 'jane@example.com',

            'channel_id' => 2,
        ]);

        Subscriber::create([
            'first_name' => 'Alice Johnson',
            'email' => 'alice@example.com',

            'channel_id' => 3,
        ]);

        Subscriber::create([
            'first_name' => 'Bob Brown',
            'email' => 'bob@example.com',

            'channel_id' => 4,
        ]);
    }
}
