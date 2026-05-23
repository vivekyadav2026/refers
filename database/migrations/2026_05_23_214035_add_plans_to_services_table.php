<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // plans JSON: { basic: { price, description, delivery, revisions, features[] }, standard: {...}, premium: {...} }
            $table->json('plans')->nullable()->after('features');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('plans');
        });
    }
};

