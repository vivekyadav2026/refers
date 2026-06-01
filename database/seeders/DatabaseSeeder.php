<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default user safely (idempotent)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // set a default password
            ]
        );

        // Seed Premium Banners and Services
        $this->call([
            PremiumDataSeeder::class,
            PackageSeeder::class,
            BusinessCategorySeeder::class,
        ]);
    }
}
