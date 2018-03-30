<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivos extends Model	{
	protected	$table	=	'archivos';

	const	CREATED_AT	=	'fecha_de_creacion';
	const	UPDATED_AT	=	'fecha_de_actualizacion';

	protected	$fillable	=	[	'id',	'nombre_del_archivo',	'ruta_del_archivo',	'tipo_de_archivo_id',	'usuario_id', 'estatus',
	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[  'tipo_de_archivo_id'];

	public  function  usuario()	{
		return $this->belongsTo('App\User');
	}

	public  function  tipo()	{
		return  $this->hasOne(	'App\Tiposarchivo',	'id',	'tipo_de_archivo_id');
	}
}
