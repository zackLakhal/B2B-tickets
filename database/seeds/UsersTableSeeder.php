<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   $type = array("agence","departement");
        for ($i=1; $i < 50; $i++) { 
           DB::table('clientusers')->insert([
                
                'name' => 'client'.$i,
                'email' => 'client'.$i.'@gmail.com',
                'password' => Hash::make(123456),
                
                'role_id' => rand(1,2),
               'nom' => "staff".$i,
               'prénom' => "client".$i ,
               'tel'  => rand(00000000,99999999),
               'adress' => " adresse ".$i,
               'created_by' => rand(1,8),
               'photo' => "avatars/placeholder.jpg"
            ]);
            DB::table('nstusers')->insert([
                'name' => 'nst'.$i,
                'email' => 'nst'.$i.'@gmail.com',
                'password' => Hash::make(123456),
                'role_id' => rand(3,4),
                'nom' => "staff".$i,
                'prénom' => "nst".$i ,
                'tel'  => rand(00000000,99999999),
                'adress' => " adresse ".$i,
                'photo' => "avatars/placeholder.jpg"
                
            ]);
        }
       
    }
}
