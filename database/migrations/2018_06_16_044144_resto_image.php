<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestoImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('restoimage', function (Blueprint $table) {
          $table->increments('id_image');
          $table->string("link");
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
        Schema::dropIfExists('restoimage');
    }
}
