<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('class_links', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('section'); // A, B, C...
            $table->enum('link_type', ['live', 'recording']); 
            $table->text('url');
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('class_links');
    }
};