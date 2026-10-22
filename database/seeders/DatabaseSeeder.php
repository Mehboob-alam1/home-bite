<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Setting;
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
        // User::factory(10)->create();

        $buyer = User::factory()->create([
            'name' => 'Test Buyer',
            'email' => 'buyer@example.com',
            'role' => 'buyer',
        ]);

        $seller = User::factory()->create([
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
            'role' => 'seller',
        ]);

        $grocer = User::factory()->create([
            'name' => 'Test Grocer',
            'email' => 'grocer@example.com',
            'role' => 'grocer',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Sample products for seller (homemade food)
        Product::create([
            'user_id' => $seller->id,
            'name' => 'Homemade Chicken Biryani',
            'description' => 'Fresh, home-style chicken biryani cooked daily.',
            'price' => 350.00,
            'type' => 'food',
            'stock' => 20,
        ]);

        Product::create([
            'user_id' => $seller->id,
            'name' => 'Paratha Roll',
            'description' => 'Egg and chicken paratha roll.',
            'price' => 150.00,
            'type' => 'food',
            'stock' => 40,
        ]);

        // Sample products for grocer
        Product::create([
            'user_id' => $grocer->id,
            'name' => '10kg Atta Bag',
            'description' => 'Quality wheat flour for daily use.',
            'price' => 1400.00,
            'type' => 'grocery',
            'stock' => 15,
        ]);

        // Default commission 10%
        Setting::set('commission_rate', '0.10');
    }
}
