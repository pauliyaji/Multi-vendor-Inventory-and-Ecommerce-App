<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoptransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoptransactions', function (Blueprint $table) {
            $table->id();
            $table->string('trx_no');
            $table->string('shop_id');
            $table->string('product_id');
            $table->string('qty');
            $table->string('cost_price');
            $table->string('total_price');
            $table->string('trxtype_id');
            $table->string('date_of_trx');
            $table->string('authorized_by');
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
        Schema::dropIfExists('shoptransactions');
    }
}
