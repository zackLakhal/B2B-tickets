<?php

use Illuminate\Database\Seeder;

class SouscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 4 ; $i++) { 
            for ($j=1; $j <=2 ; $j++) 
            {
                for ($k=1; $k <= 3 ; $k++) { 
                    for ($l=1; $l <=3 ; $l++) 
                    {
                        
                        DB::table('souscriptions')->insert([
                            'agence_id' => $i,
                            'produit_id' => $j,
                            'equipement_id' => $k,
                            'equip_ref' => "ref". $i."_".$j."_".$k,
                            
                            ]);
                    }
                }
                
            }
        }
    }

    
}
