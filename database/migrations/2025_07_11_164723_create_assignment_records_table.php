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
        Schema::create('assignment_records', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->string('score');
            $table->foreignId('assignment_id');
            $table->foreignId('student_id');
            $table->foreignId('session_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_records');
    }
};
