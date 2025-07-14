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
        Schema::create('school_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('site_images');
            $table->json('school_image');
            $table->json('principal_details');
            $table->json('nav_bar');
            $table->string('address');
            $table->string('motor');
            $table->string('po_box');
            $table->string('long_lat');
            $table->string('phone_no');
            $table->json('theme_color');
            $table->string('email_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_infos');
    }
};
