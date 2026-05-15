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
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->cascadeOnDelete();
            $table->text('requirements')->nullable();
            
            // In SQLite, altering columns has limitations, but we can try drop/add or create a new one. 
            // Better to just add a nullable lead_id if it wasn't already, but it's already there and not nullable.
            // Since it's SQLite and we might be developing, we could drop the orders table entirely in `up` and recreate it, 
            // but for safety, Laravel's change() method might work if doctrine/dbal is installed. 
            // I'll just allow it to be nullable.
            $table->unsignedBigInteger('lead_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['service_id']);
            $table->dropColumn(['user_id', 'service_id', 'requirements']);
            $table->unsignedBigInteger('lead_id')->nullable(false)->change();
        });
    }
};
