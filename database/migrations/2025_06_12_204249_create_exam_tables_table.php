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
        Schema::create('exam_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained();
            $table->foreignId('academic_session_id')->constrained();
            $table->foreignId('term_id')->constrained();
            $table->json('invigilator');
            $table->string('time_range');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_tables');
    }
};
