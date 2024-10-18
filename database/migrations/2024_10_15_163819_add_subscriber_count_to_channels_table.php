<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriberCountToChannelsTable extends Migration
{
    public function up()
    {
        Schema::table('channels', function (Blueprint $table) {
            $table->integer('subscriber_count')->default(0); // Add this line to create the column
        });
    }
}
