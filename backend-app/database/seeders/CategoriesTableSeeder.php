<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Burgers',
                'display_order' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Drinks',
                'display_order' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Burgers',
                'display_order' => 1,
            ),
        ));
        
        
    }
}