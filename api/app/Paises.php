<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model	{
	protected	$table	=	'paises';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'pais',	'codigo',	'estatus',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[];

	public  function  usuario()	{
		return $this->belongsTo('App\User');
	}

	public  function  estados()	{
		return  $this->hasMany(  'App\Estados',	'id',	'pais_id');
	}
}
