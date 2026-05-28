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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('domain_choice')->nullable()->after('platform_price');
            $table->decimal('domain_charge', 10, 2)->default(0)->after('domain_choice');
            $table->decimal('gst_amount', 10, 2)->default(0)->after('domain_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['domain_choice', 'domain_charge', 'gst_amount']);
        });
    }
};
