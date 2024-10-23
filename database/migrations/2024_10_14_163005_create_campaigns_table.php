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
            $table->id('id');
            $table->ulid('ulid');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'paused', 'completed']);
            $table->string('target_audience')->nullable();
            $table->integer('audience_size')->nullable();
            $table->string('lead_source')->nullable();
            $table->timestamps();
        });
    }
};


?>


