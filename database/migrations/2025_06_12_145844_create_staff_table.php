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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('phone_no');
            $table->string('account_no');
            $table->boolean('form_teacher');
            $table->json('subject');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('staff_role_id')->constrained();
            $table->foreignId('dues_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
