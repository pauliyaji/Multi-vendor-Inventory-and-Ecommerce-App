<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorystoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factorystores', function (Blueprint $table) {
            $table->id();
            $table->string('rawmaterial_id');
            $table->string('units_id');
            $table->string('qty');
            $table->string('supplier_id');
            $table->string('unit_price');
            $table->string('total_price');
            $table->string('paymentstatus_id');
            $table->string('date_of_supply');
            $table->string('paymentmethod_id');
            $table->string('amount_paid');
            $table->string('balance');
            $table->string('user_id');
            $table->string('remarks');
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
        Schema::dropIfExists('factorystores');
    }
}
