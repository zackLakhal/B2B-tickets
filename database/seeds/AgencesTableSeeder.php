<?php

use Illuminate\Database\Seeder;

class AgencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <21 ; $i++) { 
            for ($j=1; $j <5 ; $j++) 
            { DB::table('agences')->insert([
                'departement_id' => $i,
                'nom' => "agence".$j."-d".$i,
                'email' => "agence".$j."-d".$i."@gmail.com",
                'tel' => "0682119367",
                'adress' => "adress de l'agence ".$j."-d".$i,
                'ville_id' => rand(1,4)

                ]);
            }
        }
    }
}
