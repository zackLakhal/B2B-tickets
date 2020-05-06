<?php

use App\Souscription;
use Illuminate\Database\Seeder;

class StatistiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $souscriptions = Souscription::all();

        foreach ($souscriptions as  $souscription) {
            DB::table('reclamations')->insert([
                'ref' => "" . date('Y') . "-D" . time() . "-" . $souscription->id,
                'souscription_id' => $souscription->id,
                'clientuser_id' => 1,
                'anomalie_id' => rand(1, 9),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
