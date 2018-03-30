<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesos extends Model	{
	protected	$table	=	'pesos';

	const	CREATED_AT	=	'fecha_de_creacion';
  const	UPDATED_AT	=	'fecha_de_actualizacion';

 	protected	$fillable	=	[	'id',	'peso',	'peso_en',	'usuario_id',	'fecha_de_creacion',	'fecha_de_actualizacion'];

	protected	$hidden	=	[];

	public  function  usuario()	{
		return $this->belongsTo('App\User');
	}
}
