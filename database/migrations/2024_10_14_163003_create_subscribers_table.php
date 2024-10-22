<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('channel_id'); // Ensure channel_id exists
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('prompt')->nullable();
            $table->string('avatar_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    

};