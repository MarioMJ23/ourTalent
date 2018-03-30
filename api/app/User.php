<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  {
  use HasApiTokens, Notifiable;

  protected $table = 'usuarios';

  const CREATED_AT  = 'fecha_de_creacion';
  const UPDATED_AT  = 'fecha_de_actualizacion';

  protected $fillable = [  'id',  'descripcion',  'nombre',  'apellido_paterno',  'apellido_materno',  'apodo',  'fecha_de_nacimiento',  'email',  'password', 'telefono',  'telefono_movil',  'tipo_de_usuario_id', 'pais_id',  'estado_id',  'ciudad_id',  'estatus',  'imagen_de_perfil', 'tipo_de_sangre_id',  'institucion_id', 'fecha_de_creacion',  'fecha_de_actualizacion'  ];

  protected $hidden = [ 'password',  'tipo_de_usuario_id', 'pais_id',  'estado_id',  'ciudad_id',  'tipo_de_sangre_id',
  'institucion_id'];

  public function  tipo() {
    return  $this->hasOne(  'App\Tiposusuario', 'id', 'tipo_de_usuario_id');
  }

  public  function  pais()  {
    return  $this->hasOne(  'App\Paises', 'id', 'pais_id');
  }

  public  function  estado()  {
    return  $this->hasOne(  'App\Estados',  'id', 'estado_id');
  }

  public  function  ciudad()  {
    return  $this->hasOne(  'App\Ciudades', 'id', 'ciudad_id');
  }

  public  function  institucion() {
    return  $this->hasOne(  'App\Instituciones',  'id', 'institucion_id');
  }

  public  function  tipo_de_sangre()  {
    return  $this->hasOne(  'App\Tipossangre',  'id', 'tipo_de_sangre_id');
  }

  public  function  actividades() {
    return  $this->belongsToMany('App\Actividades', 'usuario_actividad', 'usuario_id', 'actividad_id');
  }

  public  function  pesos() {
    return  $this->hasMany( 'App\Pesos',  'usuario_id', 'id');
  }

  public  function  tallas()  {
    return  $this->hasMany( 'App\Tallas', 'usuario_id', 'id');
  }

  public  function  archivos()  {
    return  $this->hasMany( 'App\Archivos', 'usuario_id', 'id');
  }
}

