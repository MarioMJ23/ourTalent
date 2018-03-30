<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()	{
    $fdc = date('Y-m-d H:i:s',	strtotime('now'));
		$iN = 'nombre';
		$iG = 'genero';
		$iAp = 'apellido_paterno';
		$iAm = 'apellido_materno';
		$iApo  =	'apodo';
		$iFn = 'fecha_de_nacimiento';
		$iE	=	'email';
		$iP	= 'password';
		$iT	=	'telefono';
		$iTm	=	'telefono_movil';
		$iTdU	=	'tipo_de_usuario_id';
		$iPai	= 'pais_id';
		$iEs	=	'estado_id';
		$iC	=	'ciudad_id';
		$iTs	=	'tipo_de_sangre_id';
		$iI	=	'institucion_id';
		$iImgP	=	'imagen_de_perfil';
		$iFc	= 'fecha_de_creacion';

		$usuarios	=	[
			[	
				$iN	 =>	'Mario Alberto',
				$iAp	 =>	'Macías',
				$iAm	 =>	'Jasso',
				$iApo	 =>	'The King',
				$iG => 1,
				$iFn	 =>	'1994-04-04 00:00:00',
				$iE	 =>	'mari0jass0nba@gmail.com',
				$iP	 =>	Hash::make(	'D1234abcDE'),
				$iT	 =>	'014492503487',
				$iTm	 =>	'5217771960205',
				$iTdU	 =>	3,
				$iPai	 =>	147,
				$iEs	 =>	1,
				$iC	 => 	1,
				$iTs	 =>	7,
				$iI	 =>	null,
				$iImgP	 =>	'assets/imagenes/usuarios/mari0jass0nba/perfil/myImage.jpg',
				$iFc	 =>	$fdc
			],
			[	
				$iN	 =>	'Diego Eduardo',
				$iAp	 =>	'Macías',
				$iAm	 =>	'Jasso',
				$iApo	 =>	'Invalitas',
				$iG  => 1,
				$iFn	 =>	'1992-09-29 00:00:00',
				$iE	 =>	'maciasjasso0@hotmail.com',
				$iP	 =>	Hash::make(	'D1234abcDE'),
				$iT	 =>	'014492503487',
				$iTm	 =>	'5214492226190',
				$iTdU	 =>	3,
				$iPai	 =>	147,
				$iEs	 =>	1,
				$iC	 =>	1,
				$iTs	 =>	7,
				$iI	 =>	null,
				$iImgP	 =>	'assets/imagenes/usuarios/maciasjassso0/perfil/myImage.jpg',
				$iFc	 =>	$fdc
			],
			[	
				$iN	 =>	'Julio',
				$iAp	 =>	'Ybarra',
				$iAm	 =>	'Alemán',
				$iApo	 =>	'Julius',
				$iG  => 1,
				$iFn	 =>	'1995-10-04',
				$iE	 =>	'maciasjasso0@gmail.com',
				$iP	 =>	Hash::make(	'juliusY'),
				$iT	 =>	null,
				$iTm	 =>	'5219211336545',
				$iTdU	 =>	3,
				$iPai	 =>	147,
				$iEs	 =>	30,
				$iC	 =>	2287,
				$iTs	 =>	7,
				$iI	 =>	null,
				$iImgP	 =>	'assets/imagenes/usuarios/maciasjassso0g/perfil/myImage.jpg',
				$iFc	 =>	$fdc
			],
			[	
				$iN	 =>	null,
				$iAp	 =>	null,
				$iAm	 =>	null,
				$iApo	 =>	null,
				$iFn	 =>	null,
				$iE	 =>	'borregos_hidalgo@hotmail.com',
				$iP	 =>	Hash::make(	'D1234abcDE'),
				$iT	 =>	null,
				$iTm	 =>	'5217772545681',
				$iTdU	 =>	2,
				$iPai	 =>	147,
				$iEs	 =>	13,
				$iC	 =>	448,
				$iTs	 =>	null,
				$iI	 =>	1,
				$iImgP	 =>	'assets/imagenes/usuarios/borregos_hidalgo/perfil/myImage.jpg',
				$iFc	 =>	$fdc
			],
			[	
				$iN	 =>	null,
				$iAp	 =>	null,
				$iAm	 =>	null,
				$iApo	 =>	null,
				$iFn	 =>	null,
				$iE	 =>	'borregos_monterrey@hotmail.com',
				$iP	 =>	Hash::make(	'D1234abcDE'),
				$iT	 =>	null,
				$iTm	 =>	'5217772545681',
				$iTdU	 =>	2,
				$iPai	 =>	147,
				$iEs	 =>	13,
				$iC	 =>	448,
				$iTs	 =>	null,
				$iI	 =>	1,
				$iImgP	 =>	'assets/imagenes/usuarios/borregos_monterrey/perfil/myImage.jpg',
				$iFc	 =>	$fdc
			],
			[	
				$iN	 =>	null,
				$iAp	 =>	null,
				$iAm	 =>	null,
				$iApo	 =>	null,
				$iFn	 =>	null,
				$iE	 =>	'borregos_puebla@hotmail.com',
				$iP	 =>	Hash::make(	'D1234abcDE'),
				$iT	 =>	null,
				$iTm	 =>	'5217772545681',
				$iTdU	 =>	2,
				$iPai	 =>	147,
				$iEs	 =>	13,
				$iC	 =>	448,
				$iTs	 =>	null,
				$iI	 =>	1,
				$iImgP	 =>	'assets/imagenes/usuarios/borregos_puebla/perfil/myImage.jpg',
				$iFc	 =>	$fdc
			],
		];

		DB::table('usuarios')->insert(	$usuarios);
  }
}
