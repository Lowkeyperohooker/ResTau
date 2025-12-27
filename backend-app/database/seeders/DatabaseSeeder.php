<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Disable Foreign Key Checks (prevents errors when clearing tables)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Clear tables to avoid duplicates when reseeding
        DB::table('order_item_modifiers')->truncate();
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('item_modifier_links')->truncate();
        DB::table('modifiers')->truncate();
        DB::table('modifier_groups')->truncate();
        DB::table('menu_items')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        DB::table('payments')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Call the Automatically Generated Seeders
        // ORDER MATTERS: Create parents (Categories) before children (Menu Items)
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ModifierGroupsTableSeeder::class,
            ModifiersTableSeeder::class,
            MenuItemsTableSeeder::class,
            ItemModifierLinksTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            PaymentsTableSeeder::class,
        ]);
    }
}