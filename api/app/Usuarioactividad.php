<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarioactividad extends Model	{
	protected	$table	=	'usuario_actividad';

  const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'estatus',	'actividad_id',	'usuario_id',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[];
}
