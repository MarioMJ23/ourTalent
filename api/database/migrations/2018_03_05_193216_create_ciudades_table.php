<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciudades', function (Blueprint $table) {
          $table->increments('id');
          $table->string( 'ciudad');
          $table->string( 'codigo')->nullable();
          $table->integer( 'estatus')->default(1);
          $table->integer(  'estado_id')->unsigned();
          $table->foreign(  'estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('ciudades');
    }
}
