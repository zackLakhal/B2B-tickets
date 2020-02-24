<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('role_id')->nullable();
            $table->bigInteger('clientable_id')->nullable();
            $table->string('clientable_type')->nullable();
            $table->string('nom')->nullable();
            $table->string('prénom')->nullable();
         
            $table->string('tel')->nullable();
            $table->string('adress')->nullable();
            $table->string('photo')->nullable();
            $table->integer('created_by');
            $table->boolean('is_affected')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('clientusers');
    }
}
