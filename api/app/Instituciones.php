<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instituciones extends Model	{
	protected	$table	=	'instituciones';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'nombre',	'nombre_corto',	'tipo_de_institucion_id',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[	'tipo_de_institucion_id'];

	public  function  usuario()	{
		return  $this->belongsTo('App\User');
	}

	public  function  tipo()	{
		return  $this->hasOne(	'App\Tiposinstitucion',	'id',	'tipo_de_institucion_id');
	}
}
