<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_items')->delete();
        
        \DB::table('menu_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 1,
                'name' => 'Cheeseburger',
                'description' => 'Beef patty with cheddar',
                'price' => '5.99',
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/cheese-burger.png',
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 1,
                'name' => 'Chicken Sandwich',
                'description' => 'Fried chicken with mayo',
                'price' => '6.50',
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/chicken-sandwich.png',
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => 2,
                'name' => 'Coke Zero',
                'description' => 'No sugar cola',
                'price' => '1.50',
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/coke-zero.png',
            ),
            3 => 
            array (
                'id' => 4,
                'category_id' => 2,
                'name' => 'Iced Tea',
                'description' => 'Lemon flavor',
                'price' => '2.00',
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/iced-tea.png',
            ),
            4 => 
            array (
                'id' => 5,
                'category_id' => 3,
                'name' => 'Cheeseburger',
                'description' => 'Beef patty',
                'price' => '5.99',
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/burger.png',
            ),
            5 => 
            array (
                'id' => 6,
                'category_id' => 3,
                'name' => 'Bacon Burger',
                'description' => 'With crispy bacon',
                'price' => '7.99',
                'is_available' => 1,
                'image' => 'http://127.0.0.1:8000/images/bacon-burger.png',
            ),
        ));
        
        
    }
}