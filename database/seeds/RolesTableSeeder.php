<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <5 ; $i++) { 
            DB::table('roles')->insert([
                'id' => $i ,
                'value' => 'role'.$i
      
            ]);
        }
    }
}
