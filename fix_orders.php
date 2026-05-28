<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = \App\Models\Order::where('gst_amount', 0)->where('domain_charge', 0)->get();
foreach($orders as $o) {
    $plan = $o->items->first()->subtotal ?? $o->amount;
    $diff = $o->amount - ($plan + $o->platform_price);
    if ($diff > 0) {
        $gst = $plan * 0.18;
        $domain = $diff - $gst;
        if (abs($domain - 599) < 1) {
            $o->update(['domain_choice' => 'in', 'domain_charge' => 599, 'gst_amount' => $gst]);
        } elseif (abs($domain - 999) < 1) {
            $o->update(['domain_choice' => 'com', 'domain_charge' => 999, 'gst_amount' => $gst]);
        } else {
            $o->update(['gst_amount' => $gst, 'domain_charge' => $domain]);
        }
    }
}
echo "Done";
