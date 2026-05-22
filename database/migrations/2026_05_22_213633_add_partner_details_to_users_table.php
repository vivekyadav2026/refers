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
        Schema::table('users', function (Blueprint $table) {
            $table->string('alternate_phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('address_house')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_pin')->nullable();
            $table->string('address_country')->default('India')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'alternate_phone',
                'gender',
                'address_house',
                'address_street',
                'address_city',
                'address_state',
                'address_pin',
                'address_country'
            ]);
        });
    }
};
