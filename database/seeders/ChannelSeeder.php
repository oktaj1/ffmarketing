<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;

class ChannelSeeder extends Seeder
{
    public function run()
    {
        Channel::create([

            'source' => '55 Studio website',
            'email' => true,
            'sms' => false,
            'social_media' => true,
        ]);

        Channel::create([

            'source' => '55 Studio AI',
            'email' => true,
            'sms' => true,
            'social_media' => false,
        ]);

        Channel::create([

            'source' => '55 Studio Contact Form',
            'email' => false,
            'sms' => true,
            'social_media' => true,
        ]);

        Channel::create([

            'source' => '55 Studio Subscription',
            'email' => true,
            'sms' => false,
            'social_media' => true,
        ]);
    }
}
