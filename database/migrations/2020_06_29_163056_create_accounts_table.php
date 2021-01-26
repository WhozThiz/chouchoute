<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('currency');
            $table->double('opening_balance', 15, 4)->default('0.0000');
            $table->string('bank_name')->nullable();
            $table->string('bank_phone')->nullable();
            $table->text('bank_address')->nullable();
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('revenues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('lead_id');
            $table->date('paid_at');
            $table->double('amount', 15, 4);
            $table->string('currency_code', 191);
            $table->double('currency_rate', 15, 8);
            $table->text('description')->nullable();
            $table->string('payment_method', 191);
            $table->string('reference', 191)->nullable();
            $table->string('attachment', 191)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('tax_number')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('currency_code');
            $table->string('reference')->nullable();
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bill_number');
            $table->string('order_number')->nullable();
            $table->string('bill_status_code');
            $table->date('billed_at');
            $table->date('due_at');
            $table->double('amount', 15, 4);
            $table->string('currency_code');
            $table->double('currency_rate', 15, 8);
            $table->unsignedInteger('vendor_id');
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('vendor_id')->references('id')->on('vendors');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->date('paid_at');
            $table->double('amount', 15, 4);
            $table->string('currency_code');
            $table->double('currency_rate', 15, 8);
            $table->unsignedInteger('vendor_id');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('payment_method');
            $table->string('reference')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->date('paid_at');
            $table->double('amount', 15, 4);
            $table->string('currency_code', 3);
            $table->double('currency_rate', 15, 8);
            $table->unsignedInteger('account_id');
            $table->integer('document_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('category_id')->default(1);
            $table->text('description')->nullable();
            $table->string('payment_method');
            $table->string('reference')->nullable();
            $table->integer('parent_id')->default(0);
            $table->boolean('reconciled')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('lead_id')->references('id')->on('leads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('revenues');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('transactions');
    }
}
