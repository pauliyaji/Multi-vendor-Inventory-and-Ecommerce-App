<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoretrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storetrxes', function (Blueprint $table) {
            $table->id();
            $table->string('rawmaterial_id');
            $table->string('qty');
            $table->string('unit_price');
            $table->string('total_price');
            $table->string('date_of_trx');
            $table->string('trx_no');
            $table->string('barcode_id');
            $table->string('trxtype_id');
            $table->string('approvalstatus_id');
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('storetrxes');
    }
}
