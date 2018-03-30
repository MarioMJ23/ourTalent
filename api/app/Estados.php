<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model	{
	protected	$table	=	'estados';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'estado',	'codigo',	'estatus',	'pais_id',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[	'pais_id'];

	public  function  usuario()	{
		return  $this->belongsTo('App\User');
	}

	public  function  pais()  {
		return  $this->belongsTo(	'App\Paises');
	}

	public  function  ciudades()	{
		return  $this->hasMany(	'App\Ciudades',	'id',	'estado_id');
	}
}
