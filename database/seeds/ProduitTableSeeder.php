<?php

use Illuminate\Database\Seeder;

class ProduitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <6 ; $i++) { 
            DB::table('produits')->insert([
            'nom' => "produit".$i,
            'info' => "information sur le produit".$i,
            'image' => "produits/placeholder.jpg"
            ]);
            for ($j=1; $j <6 ; $j++) { 
                DB::table('equipements')->insert([
                    'produit_id' => $i,
                    'nom' => "equipement".$i."_".$j,
                    'modele' => "modèle".$i."_".$j,
                    'info' => "information sur l'équiepemt".$j." du produit ".$i,
                    'marque' => "marque".$i."_".$j,
                    'image' => "produits/placeholder.jpg"
                    ]);
            }
        }
    }
}
