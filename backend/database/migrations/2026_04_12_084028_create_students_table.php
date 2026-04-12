<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('student_id')->unique();

            $table->string('major')->nullable();
            $table->string('batch')->nullable();

            $table->timestamps();

            // Ensure 1 user == 1 student profile
            $table->unique('user_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('students');
    }
};
