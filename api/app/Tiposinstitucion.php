<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiposinstitucion extends Model	{
	protected	$table	=	'tipos_de_institucion';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'tipo',	'descripcion',  'estatus',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[];

	public  function  instituciones()	{
		return $this->belongsTo('App\Instituciones');
	}
}
