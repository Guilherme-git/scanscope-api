<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->increments('id');
            $table->text('image');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('patient');
            $table->string('date');
            $table->string('name');
            $table->string('email');
            $table->string('birthdate');
            $table->string('age');
            $table->string('gender');
            $table->string('covid');
            $table->string('pathology');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image');
    }
}
