<?php

use Illuminate\Database\Seeder;

class ArchivosTableSeeder extends Seeder
{
  public function run()	{
    $fdc = date('Y-m-d H:i:s',	strtotime('now'));
		$iNa = 'nombre_del_archivo';
		$iRa	= 'ruta_del_archivo';
		$iTa = 'tipo_de_archivo_id';
		$iU = 'usuario_id';
		$iFc = 'fecha_de_creacion';

		$archivos	=	[
			[
				$iNa	=>	'mi Imagen',
				$iRa	=>	'assets/imagenes/usuarios/mari0jass0nba/562462436t234.jpg',	
				$iTa	=>	1,
				$iU		=>	1,
				$iFc => $fdc
			],
			[
				$iNa	=>	'mi Imagen 2',
				$iRa	=>	'assets/imagenes/usuarios/mari0jass0nba/245453452452.jpg',	
				$iTa	=>	1,
				$iU		=>	1,
				$iFc => $fdc
			],
			[
				$iNa	=>	'mi Imagen 3',
				$iRa	=>	'assets/imagenes/usuarios/mari0jass0nba/32423423423.jpg',	
				$iTa	=>	1,
				$iU		=>	1,
				$iFc => $fdc
			],
			[
				$iNa	=>	'mi Imagen',
				$iRa	=>	'assets/imagenes/usuarios/maciasjassso0g/sdgsdfgsdfg.jpg',	
				$iTa	=>	1,
				$iU		=>	3,
				$iFc => $fdc
			]
		];

		DB::table('archivos')->insert(	$archivos);
  }
}
