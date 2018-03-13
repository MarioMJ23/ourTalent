<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposdeinstitucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_de_institucion', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'tipo');
            $table->string( 'descripcion');
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
        Schema::dropIfExists('tipos_de_institucion');
    }
}
