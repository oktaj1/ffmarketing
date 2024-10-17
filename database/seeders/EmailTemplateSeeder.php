<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        EmailTemplate::create([
            'name' => 'Welcome Template',
            'content' => 'Welcome to our platform!',
            'content' => 'Dear user, welcome to our platform. We are excited to have you!',
        ]);

        EmailTemplate::create([
            'name' => 'Promotion Template',
            'content' => 'Exciting Promotions for You!',
            'content' => 'Check out our latest promotions. Don’t miss out on these deals!',
        ]);
    }
}

