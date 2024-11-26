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
        Schema::create('email_templates', function (Blueprint $table) {
                $table->id('id');
                $table->ulid('ulid');
                $table->string('name');
                $table->text('content'); // Store HTML content
                $table->string('image_path')->nullable(); // Store image path (if uploaded)
                $table->timestamps();
        });
    }
};