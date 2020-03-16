<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('gender');
            $table->date('birthdate');
            $table->boolean('neutered');
            $table->char('breed');
            $table->char('coat');
            $table->char('registration_id');
            $table->tinyInteger('album_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('owners', function (Blueprint $table) {
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
        Schema::dropIfExists('owners');
    }
}
