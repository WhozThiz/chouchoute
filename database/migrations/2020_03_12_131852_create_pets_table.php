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
            $table->increments('id');
            $table->string('name');
            $table->boolean('gender');
            $table->date('birthdate');
            $table->boolean('neutered');
            $table->char('breed');
            $table->char('coat');
            $table->char('registration_id');
            $table->tinyInteger('album_id');
            $table->unsignedBigInteger('lead_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });

        Schema::create('owners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('lead_id');
            $table->unsignedInteger('pet_id');
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
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
