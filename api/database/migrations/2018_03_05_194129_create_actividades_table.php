<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->increments( 'id');
            $table->string( 'actividad');
            $table->string( 'logo');
            $table->integer( 'tipo_de_actividad_id')->unsigned();
            $table->foreign( 'tipo_de_actividad_id')->references('id')->on('tipos_de_actividad');
            $table->integer( 'estatus')->default(1);
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
        Schema::dropIfExists('actividades');
    }
}
