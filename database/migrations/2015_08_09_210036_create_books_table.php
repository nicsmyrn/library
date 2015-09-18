<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //Create books table
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isbn',15)->nullable();
            $table->string('subtitle')->nullable();
            $table->integer('year')->unsigned();

            $table->integer('e_id')->unsigned();
            $table->foreign('e_id')->references('id')->on('editors');

            $table->integer('s_id')->unsigned()->nullable();

            $table->boolean('greek')->default(true);
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('books');
    }
}
