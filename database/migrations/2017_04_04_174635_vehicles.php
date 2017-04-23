<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reg_no');
            $table->string('chassis_no');
            $table->string('engine_no');
            $table->string('model');
            $table->string('variant');
            $table->string('mfgyear');
            $table->string('mi');
            $table->string('insurance');
            $table->string('warranty');
            $table->date('warranty_exp');
            $table->string('amc');
            $table->date('amc_exp');
            $table->string('finance');
            $table->string('fuel');
            $table->integer('customer_id');
            $table->integer('user_id');
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
        Schema::drop('vehicles');
    }
}
