<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productionreports', function (Blueprint $table) {
            $table->id();
            $table->string('ptn_no');
            $table->string('total_qty');
            $table->string('total_price');
            $table->string('product_id');
            $table->string('date_of_ptn');
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
        Schema::dropIfExists('productionreports');
    }
}
