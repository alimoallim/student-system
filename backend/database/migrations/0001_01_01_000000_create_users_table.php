<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // roles: student, admin (optionally instructor)
            $table->string('role')->default('student');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};