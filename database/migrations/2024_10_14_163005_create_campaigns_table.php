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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name'); // Campaign Name
            $table->text('description')->nullable(); // Campaign Description
            $table->string('type'); // Campaign Type (e.g., email, social media)
            $table->date('start_date'); // Start Date
            $table->date('end_date')->nullable(); // End Date
            $table->enum('status', ['active', 'paused', 'completed'])->default('active'); // Status
            $table->text('target_audience')->nullable(); // Target Audience
            $table->integer('audience_size')->nullable(); // Audience Size
            $table->string('lead_source')->nullable(); // Lead Source
            $table->json('channels')->nullable(); // Channels (e.g., email, SMS, etc.)
            $table->timestamps(); // Created_at and updated_at
            $table->ulid('channel_id')->nullable()->constrained('channels', 'id');

        });
    }
};