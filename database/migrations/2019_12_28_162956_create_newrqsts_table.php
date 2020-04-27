<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewrqstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newrqsts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref')->nullable();
            $table->string('nom');
            $table->string('email');
            $table->string('tel');
            $table->text('message');
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
        Schema::dropIfExists('newrqsts');
    }
}
