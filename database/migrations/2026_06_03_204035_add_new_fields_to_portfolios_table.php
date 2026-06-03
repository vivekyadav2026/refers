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
        Schema::table('portfolios', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete()->after('id');
            $table->string('link')->nullable()->change();
            $table->string('section')->nullable()->change();
            $table->string('youtube_url')->nullable()->after('link');
            $table->string('google_drive_url')->nullable()->after('youtube_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn(['service_id', 'youtube_url', 'google_drive_url']);
            $table->string('link')->nullable(false)->change();
            $table->string('section')->nullable(false)->change();
        });
    }
};
