<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('course_code')->unique(); // e.g., CS101
            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedSmallInteger('credits')->default(3);
            $table->unsignedInteger('capacity')->default(30);

            $table->foreignId('instructor_id')
                ->constrained('instructors')
                ->cascadeOnDelete();

            $table->timestamp('enrollment_start_at')->nullable();
            $table->timestamp('enrollment_end_at')->nullable();

            $table->timestamps();

            // helpful for course dates queries
            $table->index(['enrollment_start_at', 'enrollment_end_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('courses');
    }
};
