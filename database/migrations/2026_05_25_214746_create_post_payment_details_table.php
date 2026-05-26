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
        Schema::create('post_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index(); // Using simple int so it supports multiple order systems if needed
            $table->unsignedBigInteger('user_id')->index();
            $table->string('service_name');
            $table->json('data')->nullable(); // Store form data as JSON
            $table->json('uploaded_files')->nullable(); // Store multiple image links as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_payment_details');
    }
};
