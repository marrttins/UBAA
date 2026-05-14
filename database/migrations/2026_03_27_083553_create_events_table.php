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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->datetime('event_date')->nullable();
            $table->string('event_month')->nullable();
            $table->string('event_day')->nullable();
            $table->string('location_type')->default('Physical'); // Physical, Virtual
            $table->string('location_name')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->text('image_url')->nullable();
            $table->string('fee')->nullable(); // Free, N10,000, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
