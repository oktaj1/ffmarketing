<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_channel', function (Blueprint $table) {
            $table->ulid('campaign_ulid'); // Change to campaign_ulid
            $table->ulid('channel_ulid');   // Change to channel_ulid
            $table->timestamps();
            $table->softDeletes();

            // Add foreign key constraints
            $table->foreign('campaign_ulid')->references('ulid')->on('campaigns')->onDelete('cascade');
            $table->foreign('channel_ulid')->references('ulid')->on('channels')->onDelete('cascade');
        });
    }
};
