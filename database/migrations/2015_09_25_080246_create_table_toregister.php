<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableToregister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //Create toregister table
        Schema::create('toregister', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->integer('role_id')->unsigned();
            $table->integer('org_id')->unsigned();
            $table->string('hash')->unique()->default(md5(uniqid()));
            $table->timestamps( );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
