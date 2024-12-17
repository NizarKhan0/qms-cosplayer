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
        Schema::create('fan_queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fan_id')->constrained('fans')->onDelete('cascade');
            $table->foreignId('cosplayer_id')->constrained('cosplayers')->onDelete('cascade');
            $table->integer('queue_number');
            $table->string('status')->default('pending'); // Changed from enum to string
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fan_queues');
    }
};
