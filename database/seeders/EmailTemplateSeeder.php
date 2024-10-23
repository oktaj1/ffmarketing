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
        EmailTemplate::factory()->count(4)->create();
    }
}
