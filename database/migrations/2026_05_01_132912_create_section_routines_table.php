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
        Schema::create('section_routines', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('course_short_name'); // e.g., "SPL" or "OS"
            $table->string('course_title');
            $table->string('section');
            $table->string('days'); // e.g., 'Sat, Tue', 'Sun, Wed', or 'Sat'
            $table->time('start_time'); // Stores in 24-hour format: '12:30:00'
            $table->time('end_time');   // '13:50:00'
            $table->string('faculty_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_routines');
    }
};
