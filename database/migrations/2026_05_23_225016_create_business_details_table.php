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
        Schema::create('business_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('business_name');
            $table->string('domain_name')->nullable();
            $table->string('logo_path')->nullable();
            $table->json('product_images')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('support_email')->nullable();
            $table->text('office_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_details');
    }
};
