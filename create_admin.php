#!/usr/bin/env php
<?php

define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$u = User::where('email', 'admin@sksolution.in')->first();

if (!$u) {
    $u = User::create([
        'name' => 'Super Admin',
        'email' => 'admin@sksolution.in',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]);
    echo "✅ Admin user created successfully!\n";
} else {
    $u->password = Hash::make('admin123');
    $u->role = 'admin';
    $u->save();
    echo "✅ Admin user updated. Role: " . $u->role . "\n";
}

echo "📧 Email: admin@sksolution.in\n";
echo "🔑 Password: admin123\n";
echo "🔗 Login URL: http://localhost:8000/login\n";
echo "🔗 Admin Panel: http://localhost:8000/admin/dashboard\n";
