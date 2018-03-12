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
		$iL	=	'logo';
		$iTI = 'tipo_de_institucion_id';
		$iFc = 'fecha_de_creacion';

		$instituciones	=	[
			[	$iNI => 'Tecnológico de Monterrey Campus Hidalgo',
				$iNIc	=>	'ITESM Hidalgo',
				$iL	=>	'assets/ITESMHidalgo.jpg',
				$iTI	=>	1,
				$iFc => $fdc	],
			[	$iNI => 'Tecnológico de Monterrey Campus Monterrey',
				$iNIc	=>	'ITESM Monterrey',
				$iL	=>	'assets/ITESMMonterrey.jpg',
				$iTI	=>	1,
				$iFc => $fdc	],
			[	$iNI => 'Tecnológico de Monterrey Campus Puebla',
				$iNIc	=>	'ITESM Puebla',
				$iL	=>	'assets/ITESMPuebla.jpg',
				$iTI	=>	1,
				$iFc => $fdc 	]
		];

		DB::table('instituciones')->insert(	$instituciones);
  }
}
