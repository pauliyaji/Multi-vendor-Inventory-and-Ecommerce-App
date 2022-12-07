<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDli5sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agric_infrastructure', function (Blueprint $table) {
            $table->id();
            $table->string('tot_microfcasense');
            $table->string('tot_smallfcasense');
            $table->string('tot_fcasense');
            $table->string('tot_carpprep');
            $table->string('tot_carpapprov');
            $table->string('att_prep_approv');
            $table->string('att_prep');
            $table->string('tot_agricinfrac');
            $table->string('tot_ffarmersapp');
            $table->string('tot_mfarmersapp');
            $table->string('tot_farmersapp');
            $table->string('tot_ffarmersrec');
            $table->string('tot_mfarmersrec');
            $table->string('tot_farmersrec');
            $table->string('att_app_rec');
            $table->string('pcent_att_app_rec');
            $table->string('tot_ffarmersutil');
            $table->string('tot_mfarmersutil');
            $table->string('tot_farmersutil');
            $table->string('att_farmersutil');
            $table->string('pcent_att_farmersutil');
            $table->string('tot_infracomp');
            $table->string('tot_infracomppaid');
            $table->string('att_comp_paid');

            $table->string('dli_id');
            $table->string('state_id');
            $table->string('status_id');
            $table->string('user_id');
            $table->string('dp_id');
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
        Schema::dropIfExists('agric_infrastructure');
    }
}
