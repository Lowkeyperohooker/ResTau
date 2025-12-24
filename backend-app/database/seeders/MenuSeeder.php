<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $catId = \DB::table('categories')->insertGetId(['name' => 'Burgers', 'display_order' => 1]);

    \DB::table('menu_items')->insert([
        ['category_id' => $catId, 'name' => 'Cheeseburger', 'description' => 'Beef patty', 'price' => 5.99, 'is_available' => true],
        ['category_id' => $catId, 'name' => 'Bacon Burger', 'description' => 'With crispy bacon', 'price' => 7.99, 'is_available' => true],
    ]);
}
}
