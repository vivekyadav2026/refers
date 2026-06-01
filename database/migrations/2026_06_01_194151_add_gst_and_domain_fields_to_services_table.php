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
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('enable_gst')->default(true)->after('requires_domain');
            $table->decimal('gst_percent', 10, 2)->default(18.00)->after('enable_gst');
            $table->decimal('domain_in_charge', 10, 2)->default(599.00)->after('gst_percent');
            $table->decimal('domain_com_charge', 10, 2)->default(999.00)->after('domain_in_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['enable_gst', 'gst_percent', 'domain_in_charge', 'domain_com_charge']);
        });
    }
};
