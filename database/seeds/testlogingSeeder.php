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
            'name' => 'sudo',
            'email' => 'sudo'.'@gmail.com',
            'password' => Hash::make('sudo_nst'),
            'role_id' => 6,
            'nom' => "admin",
            'prénom' => "admin" 
        ]);
    }
}
