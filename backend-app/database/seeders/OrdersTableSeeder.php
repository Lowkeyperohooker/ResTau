<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orders')->delete();
        
        \DB::table('orders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'status' => 'COMPLETED',
                'total_amount' => '2.00',
                'created_at' => '2025-12-24 06:44:11',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'status' => 'COMPLETED',
                'total_amount' => '2.00',
                'created_at' => '2025-12-24 06:46:32',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'status' => 'COMPLETED',
                'total_amount' => '27.98',
                'created_at' => '2025-12-24 07:06:09',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'status' => 'COMPLETED',
                'total_amount' => '27.96',
                'created_at' => '2025-12-24 17:17:31',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'status' => 'COMPLETED',
                'total_amount' => '29.46',
                'created_at' => '2025-12-25 08:33:19',
            ),
        ));
        
        
    }
}