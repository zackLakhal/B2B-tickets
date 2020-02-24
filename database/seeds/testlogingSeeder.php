<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class testlogingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientusers')->insert([
            'id' => 1,
            'name' => 'client1',
            'email' => 'client1@gmail.com',
            'password' => Hash::make(123456),
            'clientable_id' => 1,
            'clientable_type' => "test"
        ]);
        DB::table('nstusers')->insert([
            'id' => 1,
            'name' => 'nst1',
            'email' => 'nst1@gmail.com',
            'password' => Hash::make(123456)
            
        ]);
    }
}
