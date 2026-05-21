<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Enhance orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('requirements');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            $table->string('company_name')->nullable()->after('customer_phone');
            $table->string('business_type')->nullable()->after('company_name');
            $table->string('file_upload')->nullable()->after('business_type');
            $table->string('razorpay_order_id')->nullable()->after('file_upload');
            $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            $table->foreignId('referred_by_partner')->nullable()->constrained('users')->nullOnDelete()->after('razorpay_payment_id');
        });

        // Update order status enum to include more statuses
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','paid','in_progress','completed','cancelled') DEFAULT 'pending'");
        }

        // Enhance services table
        Schema::table('services', function (Blueprint $table) {
            $table->text('description')->nullable()->after('short_description');
            $table->string('banner_image')->nullable()->after('icon');
            $table->string('delivery_timeline')->nullable()->after('banner_image');
            $table->json('faqs')->nullable()->after('features');
            $table->text('portfolio')->nullable()->after('faqs');
            $table->text('requirements_text')->nullable()->after('portfolio');
            $table->decimal('commission_rate', 5, 2)->nullable()->after('requirements_text');
            $table->enum('commission_type', ['fixed', 'percentage'])->default('percentage')->after('commission_rate');
        });

        // Create partner_referrals table
        Schema::create('partner_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('referral_code');
            $table->string('ip_address')->nullable();
            $table->enum('status', ['clicked', 'registered', 'purchased'])->default('clicked');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_referrals');

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'description', 'banner_image', 'delivery_timeline',
                'faqs', 'portfolio', 'requirements_text',
                'commission_rate', 'commission_type'
            ]);
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','paid') DEFAULT 'pending'");
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['referred_by_partner']);
            $table->dropColumn([
                'customer_name', 'customer_email', 'customer_phone',
                'company_name', 'business_type', 'file_upload',
                'razorpay_order_id', 'razorpay_payment_id', 'referred_by_partner'
            ]);
        });
    }
};
