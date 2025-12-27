<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password_hash' => '$2y$12$lhxOrn3x064EBufwFTSbkOaEgkFh2IAUF3UGr9QycjFmcCaAlUp3C',
                'role' => 'ADMIN',
                'created_at' => '2025-12-24 14:31:09',
            ),
        ));
        
        
    }
}