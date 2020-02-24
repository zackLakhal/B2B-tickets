<?php

use Illuminate\Database\Seeder;

class RqstsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=5; $i <10 ; $i++) { 
            DB::table('newrqsts')->insert([
                'id' => $i ,
            'nom' => "nom".$i,
            'email' => "email".$i."@gmail.com",
            'tel' => "0682119367",
            'message' => "here is new request nember ".$i
      
            ]);
        }
    }
}
