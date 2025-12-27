<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Disable Foreign Key Checks to allow truncating tables safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Clear all tables first
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('menu_items')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        // Clear other tables that were empty in your dump
        DB::table('item_modifier_links')->truncate();
        DB::table('modifiers')->truncate();
        DB::table('modifier_groups')->truncate();
        DB::table('order_item_modifiers')->truncate();
        DB::table('payments')->truncate();

        // 3. Re-enable Foreign Key Checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- USERS ---
        // I replaced 'dummy_hash_123' with a real hash for 'password' so you can login.
        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'admin',
                'password_hash' => Hash::make('password'), // Login with password: 'password'
                'role' => 'ADMIN',
                'created_at' => '2025-12-24 14:31:09',
            ]
        ]);

        // --- CATEGORIES ---
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Burgers', 'display_order' => 1],
            ['id' => 2, 'name' => 'Drinks', 'display_order' => 2],
            ['id' => 3, 'name' => 'Burgers', 'display_order' => 1], // Preserving duplicate category from your dump
        ]);

        // --- MENU ITEMS ---
        DB::table('menu_items')->insert([
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Cheeseburger',
                'description' => 'Beef patty with cheddar',
                'price' => 5.99,
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/cheese-burger.png',
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'name' => 'Chicken Sandwich',
                'description' => 'Fried chicken with mayo',
                'price' => 6.50,
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/chicken-sandwich.png',
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'name' => 'Coke Zero',
                'description' => 'No sugar cola',
                'price' => 1.50,
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/coke-zero.png',
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'name' => 'Iced Tea',
                'description' => 'Lemon flavor',
                'price' => 2.00,
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/iced-tea.png',
            ],
            [
                'id' => 5,
                'category_id' => 3,
                'name' => 'Cheeseburger',
                'description' => 'Beef patty',
                'price' => 5.99,
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/burger.png',
            ],
            [
                'id' => 6,
                'category_id' => 3,
                'name' => 'Bacon Burger',
                'description' => 'With crispy bacon',
                'price' => 7.99,
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/bacon-burger.png',
            ],
        ]);

        // --- ORDERS ---
        DB::table('orders')->insert([
            ['id' => 1, 'user_id' => 1, 'status' => 'COMPLETED', 'total_amount' => 2.00,  'created_at' => '2025-12-24 06:44:11'],
            ['id' => 2, 'user_id' => 1, 'status' => 'COMPLETED', 'total_amount' => 2.00,  'created_at' => '2025-12-24 06:46:32'],
            ['id' => 3, 'user_id' => 1, 'status' => 'COMPLETED', 'total_amount' => 27.98, 'created_at' => '2025-12-24 07:06:09'],
            ['id' => 4, 'user_id' => 1, 'status' => 'COMPLETED', 'total_amount' => 27.96, 'created_at' => '2025-12-24 17:17:31'],
            ['id' => 5, 'user_id' => 1, 'status' => 'COMPLETED', 'total_amount' => 29.46, 'created_at' => '2025-12-25 08:33:19'],
        ]);

        // --- ORDER ITEMS ---
        DB::table('order_items')->insert([
            // Order 1
            ['id' => 1, 'order_id' => 1, 'menu_item_id' => 4, 'quantity' => 1, 'price_at_order' => 2.00],
            
            // Order 2
            ['id' => 2, 'order_id' => 2, 'menu_item_id' => 4, 'quantity' => 1, 'price_at_order' => 2.00],

            // Order 3
            ['id' => 3, 'order_id' => 3, 'menu_item_id' => 2, 'quantity' => 2, 'price_at_order' => 6.50],
            ['id' => 4, 'order_id' => 3, 'menu_item_id' => 3, 'quantity' => 2, 'price_at_order' => 1.50],
            ['id' => 5, 'order_id' => 3, 'menu_item_id' => 5, 'quantity' => 2, 'price_at_order' => 5.99],

            // Order 4
            ['id' => 6, 'order_id' => 4, 'menu_item_id' => 1, 'quantity' => 2, 'price_at_order' => 5.99],
            ['id' => 7, 'order_id' => 4, 'menu_item_id' => 6, 'quantity' => 2, 'price_at_order' => 7.99],

            // Order 5
            ['id' => 8,  'order_id' => 5, 'menu_item_id' => 1, 'quantity' => 2, 'price_at_order' => 5.99],
            ['id' => 9,  'order_id' => 5, 'menu_item_id' => 4, 'quantity' => 1, 'price_at_order' => 2.00],
            ['id' => 10, 'order_id' => 5, 'menu_item_id' => 3, 'quantity' => 1, 'price_at_order' => 1.50],
            ['id' => 11, 'order_id' => 5, 'menu_item_id' => 6, 'quantity' => 1, 'price_at_order' => 7.99],
            ['id' => 12, 'order_id' => 5, 'menu_item_id' => 5, 'quantity' => 1, 'price_at_order' => 5.99],
        ]);
    }
}