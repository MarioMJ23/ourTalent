<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiposarchivo extends Model	{
	protected	$table	=	'tipos_de_archivo';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'tipo',  'estatus',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[];

	public  function  archivo()	{
		return $this->belongsTo('App\Archivos');
	}
}
