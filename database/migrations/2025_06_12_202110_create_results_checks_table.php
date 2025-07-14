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
        Schema::create('results_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained();
            $table->foreignId('dues_id')->constrained();
            $table->string('token');
            $table->string('number_of_attempts');
            $table->string('status');// expired, valid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results_checks');
    }
};
