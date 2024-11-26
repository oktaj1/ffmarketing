<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStyleToEmailTemplates extends Migration
{
    public function up()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->string('style')->default('style1'); // Default style
        });
    }
}
