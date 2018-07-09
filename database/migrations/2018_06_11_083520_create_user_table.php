<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string("username",30);
            $table->string("password",40);
            $table->string("email",100);
            $table->string("name",60);
            $table->string("verifyHash",40);
            $table->boolean("verified")->default(false);
            $table->date("joined");
            $table->softDeletes();

            //indexes
            $table->unique(["username","email"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
