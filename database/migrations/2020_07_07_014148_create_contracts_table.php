<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->date('paid_at');
            $table->double('amount', 15, 4);
            $table->string('currency_code');
            $table->double('currency_rate', 15, 8);
            $table->unsignedBigInteger('lead_id');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('payment_method');
            $table->string('reference')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
