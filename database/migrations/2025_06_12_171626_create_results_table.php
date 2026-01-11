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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('class_type_id')->constrained();
            $table->foreignId('term_id')->constrained();     // e.g., 'First', 'Second', 'Third'
            $table->foreignId('academic_session_id')->constrained();  // e.g., '2024/2025'
            $table->string('level');
            $table->foreignId('grade_scale_id')->constrained();
            $table->string('test1')->nullable();
            $table->string('test2')->nullable();
            $table->string('assignment1')->nullable();
            $table->string('assignment2')->nullable();
            $table->string('total')->nullable();
            $table->string('exam')->nullable();
            $table->timestamps();


            //this tells the model "This combination of values should be unique." so it can be used to upsert
            $table->unique(
                ['student_id', 'subject_id', 'class_type_id', 'term_id', 'academic_session_id'],
                'unique_result_entry'
            );

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
        Schema::table('results', function (Blueprint $table) {
            $table->dropUnique('unique_result_entry');
        });
    }
};
