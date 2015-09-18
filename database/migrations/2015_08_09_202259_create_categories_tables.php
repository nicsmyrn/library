<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('type_category', function(Blueprint $table){
            $table->increments('id');
            $table->string('t_name');
        });

        Schema::create('category', function(Blueprint $table){
            $table->increments('id');
            $table->string('cat_id',30);
            $table->string('name', 120);
            $table->string('parent_id', 30);
            $table->smallInteger('level')->unsigned();
            $table->boolean('dewey')->default(false);
            $table->unsignedInteger('type');
            $table->foreign('type')->references('id')->on('type_category');
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
        //
        Schema::drop('category');
        Schema::drop('type_category');
    }
}
