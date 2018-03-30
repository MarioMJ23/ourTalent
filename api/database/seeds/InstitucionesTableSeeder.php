<?php

use Illuminate\Database\Seeder;

class InstitucionesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()	{
    $fdc = date('Y-m-d H:i:s',	strtotime('now'));
		$iNI = 'nombre';
		$iNIc = 'nombre_corto';
		//$iL	=	'logo';
		$iTI = 'tipo_de_institucion_id';
		$iFc = 'fecha_de_creacion';

		/*
			$iL	=>	'assets/ITESMHidalgo.jpg',
			$iL	=>	'assets/ITESMMonterrey.jpg',
			$iL	=>	'assets/ITESMPuebla.jpg',
		*/
		$instituciones	=	[
			[	$iNI => 'Tecnológico de Monterrey Campus Hidalgo',
				$iNIc	=>	'ITESM Hidalgo',
				$iTI	=>	1,
				$iFc => $fdc	],
			[	$iNI => 'Tecnológico de Monterrey Campus Monterrey',
				$iNIc	=>	'ITESM Monterrey',
				$iTI	=>	1,
				$iFc => $fdc	],
			[	$iNI => 'Tecnológico de Monterrey Campus Puebla',
				$iNIc	=>	'ITESM Puebla',
				$iTI	=>	1,
				$iFc => $fdc 	]
		];

		DB::table('instituciones')->insert(	$instituciones);
  }
}
