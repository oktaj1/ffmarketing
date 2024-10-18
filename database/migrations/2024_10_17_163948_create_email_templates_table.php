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
            $table->id();
            $table->string('name'); 
            $table->text('content'); 
            $table->foreignId('campaign_id') 
                  ->constrained()
                  ->onDelete('cascade'); 
            $table->timestamps(); 
        });
    }
};