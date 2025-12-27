<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_items')->delete();
        
        \DB::table('order_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'order_id' => 1,
                'menu_item_id' => 4,
                'quantity' => 1,
                'price_at_order' => '2.00',
            ),
            1 => 
            array (
                'id' => 2,
                'order_id' => 2,
                'menu_item_id' => 4,
                'quantity' => 1,
                'price_at_order' => '2.00',
            ),
            2 => 
            array (
                'id' => 3,
                'order_id' => 3,
                'menu_item_id' => 2,
                'quantity' => 2,
                'price_at_order' => '6.50',
            ),
            3 => 
            array (
                'id' => 4,
                'order_id' => 3,
                'menu_item_id' => 3,
                'quantity' => 2,
                'price_at_order' => '1.50',
            ),
            4 => 
            array (
                'id' => 5,
                'order_id' => 3,
                'menu_item_id' => 5,
                'quantity' => 2,
                'price_at_order' => '5.99',
            ),
            5 => 
            array (
                'id' => 6,
                'order_id' => 4,
                'menu_item_id' => 1,
                'quantity' => 2,
                'price_at_order' => '5.99',
            ),
            6 => 
            array (
                'id' => 7,
                'order_id' => 4,
                'menu_item_id' => 6,
                'quantity' => 2,
                'price_at_order' => '7.99',
            ),
            7 => 
            array (
                'id' => 8,
                'order_id' => 5,
                'menu_item_id' => 1,
                'quantity' => 2,
                'price_at_order' => '5.99',
            ),
            8 => 
            array (
                'id' => 9,
                'order_id' => 5,
                'menu_item_id' => 4,
                'quantity' => 1,
                'price_at_order' => '2.00',
            ),
            9 => 
            array (
                'id' => 10,
                'order_id' => 5,
                'menu_item_id' => 3,
                'quantity' => 1,
                'price_at_order' => '1.50',
            ),
            10 => 
            array (
                'id' => 11,
                'order_id' => 5,
                'menu_item_id' => 6,
                'quantity' => 1,
                'price_at_order' => '7.99',
            ),
            11 => 
            array (
                'id' => 12,
                'order_id' => 5,
                'menu_item_id' => 5,
                'quantity' => 1,
                'price_at_order' => '5.99',
            ),
        ));
        
        
    }
}