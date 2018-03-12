<?php

use Illuminate\Database\Seeder;

class ActividadesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()	{
    $fdc = date('Y-m-d H:i:s',	strtotime('now'));
		$iAc = 'actividad';
		$iLa	= 'logo';
		$iTA = 'tipo_de_actividad_id';
		$iFc = 'fecha_de_creacion';

		$actividades	=	[
			[	$iAc => 'Futbol soccer',	$iLa	=>	'soccer', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Baloncesto',	$iLa	=>	'basketball', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Futbol americano',	$iLa	=>	'americano', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Tenis',	$iLa	=>	'tenis', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Ajedrez',	$iLa	=>	'ajedres', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Gimnasia',	$iLa	=>	'gimnasia', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Baseball',	$iLa	=>	'baseball', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Box',	$iLa	=>	'box', $iTA	=>	1, $iFc => $fdc],
			[	$iAc => 'Danza',	$iLa	=>	'danza', $iTA	=>	2, $iFc => $fdc],
			[	$iAc => 'Actuación',	$iLa	=>	'actuacion', $iTA	=>	2, $iFc => $fdc]
		];

		DB::table('actividades')->insert(	$actividades);
  }
}
