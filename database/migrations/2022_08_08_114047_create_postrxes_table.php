<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postrxes', function (Blueprint $table) {
            $table->id();
            $table->string('pos_no');
            $table->string('shop_id');
            $table->string('customer_id');
            $table->string('discount');
            $table->string('selling_price');
            $table->string('total_amount');
            $table->string('amount_paid');
            $table->string('balance');
            $table->string('paymentmethod_id');
            $table->string('postrxtype_id');
            $table->string('paymentstatus_id');
            $table->string('user_id');
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
        Schema::dropIfExists('postrxes');
    }
}
