<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannelIdToSubscribersTable extends Migration
{
    public function up()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->foreignId('channel_id')->constrained()->onDelete('cascade'); // Add foreign key to channels table
        });
    }

    public function down()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropForeign(['channel_id']); // Drop foreign key
            $table->dropColumn('channel_id'); // Drop the column
        });
    }
}
