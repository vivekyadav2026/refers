<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code')->nullable()->unique()->after('phone');
            $table->string('company_name')->nullable()->after('referral_code');
            $table->string('business_type')->nullable()->after('company_name');
        });

        // For MySQL: alter the role enum to include 'customer'
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','partner','customer') DEFAULT 'customer'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','partner') DEFAULT 'partner'");
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['referral_code', 'company_name', 'business_type']);
        });
    }
};
