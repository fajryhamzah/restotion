<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestoranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restoran', function (Blueprint $table) {
            $table->increments('id_restoran');
            $table->string("nama_restoran",50);
            $table->text("detail_restoran");
            $table->decimal("latitude",10,8);
            $table->decimal("longitude",11,8);
            $table->integer("id_owner")->unsigned();
            $table->foreign('id_owner')->references("id")->on("user");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restoran');
    }
}
