<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Disable Foreign Key Checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Clear tables
        DB::table('payments')->truncate();
        // DB::table('order_item_modifiers')->truncate();
        // DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('item_modifier_links')->truncate();
        DB::table('menu_items')->truncate();
        DB::table('modifiers')->truncate();
        DB::table('modifier_groups')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Call Seeders (RUN EACH ONLY ONCE)
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ModifierGroupsTableSeeder::class,
            ModifiersTableSeeder::class,
            MenuItemsTableSeeder::class,
            ItemModifierLinksTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            OrderItemModifiersTableSeeder::class,
            PaymentsTableSeeder::class,
            // <--- MAKE SURE THERE ARE NO DUPLICATES BELOW THIS LINE
        ]);
    }
}