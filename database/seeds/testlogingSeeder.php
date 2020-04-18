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
       
        DB::table('nstusers')->insert([
            'id' => 1,
            'name' => 'nst1',
            'email' => 'nst1@gmail.com',
            'password' => Hash::make(123456)
            
        ]);
    }
}
