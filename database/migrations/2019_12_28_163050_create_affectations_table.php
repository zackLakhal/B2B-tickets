<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffectationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reclamation_id');
            $table->bigInteger('nstuser_id');
            $table->boolean('accepted')->default(false);
            $table->dateTime('accepted_at')->nullable();
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
        Schema::dropIfExists('affectations');
    }
}
