<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('usuarios', function (Blueprint $table) {
          $table->increments('ID');
          $table->string( 'nombre')->nullable();
          $table->string( 'apellido_paterno')->nullable();
          $table->string( 'apellido_materno')->nullable();
          $table->string( 'apodo')->nullable();
          $table->dateTime( 'fecha_de_nacimiento')->nullable();
          $table->string( 'email')->unique();
          $table->string( 'password');
          $table->string( 'telefono')->nullable();
          $table->string( 'telefono_movil');
          $table->integer(  'tipo_de_usuario_id')->unsigned();
          $table->foreign(  'tipo_de_usuario_id')->references('ID')->on('tipos_de_usuario');
          $table->integer(  'pais_id')->unsigned();
          $table->foreign(  'pais_id')->references('ID')->on('paises');
          $table->integer(  'estado_id')->unsigned();
          $table->foreign(  'estado_id')->references('ID')->on('estados');
          $table->integer(  'ciudad_id')->unsigned();
          $table->foreign(  'ciudad_id')->references('ID')->on('ciudades');
          $table->integer(  'estatus')->default(1);
          $table->string( 'imagen_de_perfil')->nullable();
          $table->integer(  'tipo_de_sangre_id')->unsigned()->nullable();
          $table->foreign(  'tipo_de_sangre_id')->references('ID')->on('tipos_de_sangre');
          $table->integer(  'institucion_id')->unsigned()->nullable();
          $table->foreign(  'institucion_id')->references('ID')->on('instituciones');
          $table->dateTime( 'fecha_de_creacion');
          $table->dateTime( 'fecha_de_actualizacion')->nullable();
          $table->rememberToken();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
