<?php
$s = App\Models\Service::first();
if ($s) {
    $s->plans = [
        [
            'name' => 'Basic',
            'description' => 'Perfect for small business',
            'delivery' => '5 Days',
            'features' => "Feature 1\nFeature 2"
        ],
        [
            'name' => 'Standard',
            'description' => 'Ideal for growing businesses',
            'delivery' => '10 Days',
            'features' => "Feature 1\nFeature 2\nFeature 3"
        ],
        [
            'name' => 'Premium',
            'description' => 'Enterprise level solution',
            'delivery' => '15 Days',
            'features' => "Feature 1\nFeature 2\nFeature 3\nFeature 4"
        ]
    ];
    $s->enable_platforms = true;
    $s->platforms = [
        ['name' => 'WordPress'],
        ['name' => 'Shopify'],
        ['name' => 'Custom PHP']
    ];
    $s->pricing_matrix = [
        'WordPress' => [
            'Basic' => 15000,
            'Standard' => 25000,
            'Premium' => 40000
        ],
        'Shopify' => [
            'Basic' => 20000,
            'Standard' => 35000,
            'Premium' => 50000
        ],
        'Custom PHP' => [
            'Basic' => 30000,
            'Standard' => 50000,
            'Premium' => 80000
        ]
    ];
    $s->save();
    echo "Service updated: " . $s->name . "\n";
} else {
    echo "No services found.\n";
}
