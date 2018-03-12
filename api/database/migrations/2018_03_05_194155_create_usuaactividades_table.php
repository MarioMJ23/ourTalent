<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuaactividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_actividad', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer(    'estatus')->default(1);
            $table->integer(  'actividad_id')->unsigned();
            $table->foreign(  'actividad_id')->references('ID')->on('actividades');
            $table->integer(  'usuario_id')->unsigned();
            $table->foreign(  'usuario_id')->references('ID')->on('usuarios');
            $table->dateTime( 'fecha_de_creacion');
            $table->dateTime( 'fecha_de_actualizacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_actividad');
    }
}
