<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('archivos', function (Blueprint $table) {
        $table->increments('ID');
        $table->string( 'nombre_del_archivo');
        $table->string( 'ruta_del_archivo');
        $table->integer( 'estatus')->default(1);
        $table->integer('tipo_de_archivo_id')->unsigned();
        $table->foreign( 'tipo_de_archivo_id')->references('ID')->on('tipos_de_archivo');
        $table->integer( 'usuario_id')->unsigned();
        $table->foreign( 'usuario_id')->references('ID')->on('usuarios');
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
      Schema::dropIfExists('archivos');
  }
}
