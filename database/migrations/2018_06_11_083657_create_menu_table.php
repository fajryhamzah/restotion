<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id_menu');
            $table->string("nama_menu",50);
            $table->string("detail_menu",60);
            $table->string("image");
            $table->integer("harga");
            $table->enum("tipe",["Appetizer","Main Dishes","Drinks","Desserts"]);
            $table->integer("id_restoran")->unsigned();
            $table->foreign('id_restoran')->references("id_restoran")->on("restoran");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
