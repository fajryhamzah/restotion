<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMejaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->increments('id_meja');
            $table->string("nama_meja",30);
            $table->integer("kapasitas");
            $table->string("keterangan");
            $table->boolean("status");
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
        Schema::dropIfExists('meja');
    }
}
