<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTallasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tallas', function (Blueprint $table) {
            $table->increments('id');
            $table->float(  'talla');
            $table->float(  'talla_en');
            $table->integer(  'usuario_id')->unsigned();
            $table->foreign( 'usuario_id')->references('id')->on('usuarios');
            $table->dateTime(   'fecha_de_creacion');
            $table->dateTime(   'fecha_de_actualizacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tallas');
    }
}
