<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelSeeder extends Seeder
{
    public function run()
    {
        Channel::factory()->count(4)->create();
    }
}
