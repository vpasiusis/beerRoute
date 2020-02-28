<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   

    public function up()
    {
        Schema::create('beers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brewery_id');
            $table->string('name');
            $table->integer('cat_id');
            $table->integer('style_id');
            $table->float('abv');
            $table->integer('ibu');
            $table->integer('srm');
            $table->integer('upc');
            $table->string('filepath');
            $table->longText('descript');
            $table->integer('add_user');
            $table->date('last_mod');
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
        Schema::dropIfExists('beers');
    }
}
