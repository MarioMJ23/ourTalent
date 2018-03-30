<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model	{
	protected	$table	=	'ciudades';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'ciudad',	'codigo',	'estatus',	'estado_id',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[	'estado_id'];

	public  function  usuario()	 {
		return  $this->belongsTo(  'App\User');
	}

	public  function  estado()  {
		return  $this->belongsTo(  'App\Estados');
	}
}
