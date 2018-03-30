<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiposusuario extends Model	{
	protected	$table	=	'tipos_de_usuario';

  const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'tipo',  'estatus',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[];

	public  function  usuario()	{
		return $this->belongsTo('App\User');
	}
}
