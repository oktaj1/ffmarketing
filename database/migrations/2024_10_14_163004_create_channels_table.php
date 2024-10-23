<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid');
            $table->boolean('email')->default(false);
            $table->boolean('sms')->default(false);
            $table->boolean('social_media')->default(false);
            $table->string('source');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};