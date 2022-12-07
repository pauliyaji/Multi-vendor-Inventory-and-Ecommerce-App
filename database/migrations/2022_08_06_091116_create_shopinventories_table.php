<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopinventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopinventories', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id');
            $table->string('product_id');
            $table->string('qty');
            $table->string('cost_price');
            $table->string('selling_price');
            $table->string('alert_qty');
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
        Schema::dropIfExists('shopinventories');
    }
}
