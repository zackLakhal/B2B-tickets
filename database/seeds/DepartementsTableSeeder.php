<?php

use Illuminate\Database\Seeder;

class DepartementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <11 ; $i++) { 
            for ($j=1; $j <3 ; $j++) 
            { DB::table('departements')->insert([
                'client_id' => $i,
                'nom' => "departement".$j."-c".$i,
                'email' => "depart".$j."-c".$i."@gmail.com",
                'tel' => "0682119367"
                ]);
            }
        }
    }
}
