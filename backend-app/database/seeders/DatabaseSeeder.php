<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Admin User
        DB::table('users')->insertOrIgnore([
            'username' => 'admin',
            'password_hash' => 'dummy_hash_123', // In real life, use Hash::make('password')
            'role' => 'ADMIN',
        ]);

        // 2. Create Categories
        $burgerId = DB::table('categories')->insertGetId(['name' => 'Burgers', 'display_order' => 1]);
        $drinkId = DB::table('categories')->insertGetId(['name' => 'Drinks', 'display_order' => 2]);

        // 3. Create Menu Items
        DB::table('menu_items')->insertOrIgnore([
            [
                'category_id' => $burgerId,
                'name' => 'Cheeseburger',
                'description' => 'Beef patty with cheddar',
                'price' => 5.99,
                'is_available' => true,
                'image' => null
            ],
            [
                'category_id' => $burgerId,
                'name' => 'Chicken Sandwich',
                'description' => 'Fried chicken with mayo',
                'price' => 6.50,
                'is_available' => true,
                'image' => null
            ],
            [
                'category_id' => $drinkId,
                'name' => 'Coke Zero',
                'description' => 'No sugar cola',
                'price' => 1.50,
                'is_available' => true,
                'image' => null
            ],
            [
                'category_id' => $drinkId,
                'name' => 'Iced Tea',
                'description' => 'Lemon flavor',
                'price' => 2.00,
                'is_available' => true,
                'image' => null
            ]
        ]);
    }
}