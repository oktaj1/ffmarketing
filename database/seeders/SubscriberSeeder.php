<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscriber;
use App\Models\Channel;
use Illuminate\Support\Str;
use App\Traits\HasUlid;

class SubscriberSeeder extends Seeder

{
    public function run()
    {
        Subscriber::factory()->count(4)->create();
    }
}
