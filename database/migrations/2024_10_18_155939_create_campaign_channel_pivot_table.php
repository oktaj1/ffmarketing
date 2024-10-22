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
            $table->ulid('id')->primary();
            $table->ulid('campaign_id')->constrained()->onDelete('cascade');
            $table->ulid('channel_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

};
