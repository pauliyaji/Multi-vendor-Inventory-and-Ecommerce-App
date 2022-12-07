<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductiontrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productiontrxes', function (Blueprint $table) {
            $table->id();
            $table->string('rawmaterial_id');
            $table->string('qty');
            $table->string('unit_price');
            $table->string('trx_no');
            $table->string('trx_type');
            $table->string('status');
            $table->string('qty_used');
            $table->string('qty_returned');
            $table->string('waste');
            $table->string('total_price_used');
            $table->string('total_price_returned');
            $table->string('remarks');
            $table->string('date_of_trx');
            $table->string('ptn_no');
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
        Schema::dropIfExists('productiontrxes');
    }
}
