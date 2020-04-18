<?php

use Illuminate\Database\Seeder;

class AnomalieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <10 ; $i++) { 
            DB::table('anomalies')->insert([
            'id' => $i,
            'value' => "anomalie-".$i
          
            ]);
        }
    }
}
