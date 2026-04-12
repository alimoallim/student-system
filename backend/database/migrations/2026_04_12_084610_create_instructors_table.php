<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();

            $table->string('instructor_id')->unique();
            $table->string('full_name');

            $table->string('email')->unique()->nullable(); // optional if instructors don't log in

            $table->string('department')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('instructors');
    }
};

