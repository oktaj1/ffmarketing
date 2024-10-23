<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('channel_id');
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('prompt')->nullable();
            $table->string('avatar_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('channel_id')->references('id')->on('channels');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
};