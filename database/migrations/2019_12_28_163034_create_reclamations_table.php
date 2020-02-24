<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReclamationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclamations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('produit_id'); 
            $table->bigInteger('clientuser_id');
            $table->bigInteger('etat_id'); 
            $table->bigInteger('anomalie_id'); 
            $table->text('commentaire');
            $table->dateTime('checked_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
$table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reclamations');
    }
}
