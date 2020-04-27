<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref');
            $table->bigInteger('affectation_id');
            $table->string('type')->default("");
            $table->boolean('with_pv')->default(false);
            $table->text('commentaire')->default("");
            $table->string('pv')->default("");
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
        Schema::dropIfExists('raports');
    }
}
