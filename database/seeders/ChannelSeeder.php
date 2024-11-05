<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;

class ChannelSeeder extends Seeder
{
    public function run()
    {
        // Use the factory to create 4 channels
        Channel::factory()->count(4)->create();  // Adjust the count as needed
    }
}

