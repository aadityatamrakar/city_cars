<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('password');
            $table->integer('role');
            // 1 Lookup, 2 Data entry, 3 Admin, 4 Super Admin
            $table->string('remember_token')->nullable();
            $table->string('status', 10)->nullable();
            $table->tinyInteger('block')->default(0);
            $table->timestamp('password_changed');
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
        Schema::drop('users');
    }
}
