<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model	{
	protected	$table	=	'actividades';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

  protected	$fillable	=	[	'id',	'actividad',	'logo',	'tipo_de_actividad_id',	'fecha_de_creacion',	'fecha_de_actualizacion'];

  protected	$hidden	=	[ 'tipo_de_actividad_id'];

  public  function  usuarios()	{
		return  $this->belongsToMany('App\User', 'usuario_actividad', 'actividad_id', 'usuario_id');
  }

  public  function  tipo()	{
  	return  $this->hasOne(	'App\Tiposactividad',	'id',	'tipo_de_actividad_id');
  }
}
