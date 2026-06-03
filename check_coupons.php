<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$coupons = \App\Models\Coupon::all();
echo "Total coupons: " . $coupons->count() . "\n";
foreach ($coupons as $c) {
    echo "Code: {$c->code} | is_active: " . (int)$c->is_active . " | expires_at: {$c->expires_at} | service_id: {$c->service_id}\n";
}

$active = \App\Models\Coupon::where('is_active', true)
    ->where(function($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>', now()); })
    ->get();
echo "\nActive coupons visible to customer: " . $active->count() . "\n";
