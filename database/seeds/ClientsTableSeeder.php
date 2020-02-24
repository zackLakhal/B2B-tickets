<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <9 ; $i++) { 
            DB::table('clients')->insert([
            'id' => $i ,
            'nom' => "client".$i,
            'email' => "email".$i."@gmail.com",
            'tel' => "0682119367",
            'adress' => "hay nahda ".$i." N° ".$i." témara",
            'photo' => "clients/placeholder.jpg"
      
            ]);
        }
    }
}
