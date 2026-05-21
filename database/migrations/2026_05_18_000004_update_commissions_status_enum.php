<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE commissions MODIFY COLUMN status ENUM('pending','cleared','paid','rejected') DEFAULT 'pending'");
            DB::statement("ALTER TABLE commissions MODIFY COLUMN type ENUM('direct','referral','percentage','fixed') DEFAULT 'percentage'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE commissions MODIFY COLUMN status ENUM('pending','cleared') DEFAULT 'pending'");
            DB::statement("ALTER TABLE commissions MODIFY COLUMN type ENUM('direct','referral') DEFAULT 'direct'");
        }
    }
};
