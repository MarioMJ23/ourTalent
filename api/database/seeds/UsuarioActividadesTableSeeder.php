<?php

use Illuminate\Database\Seeder;

class UsuarioActividadesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()	{
		$fdc = date('Y-m-d H:i:s',	strtotime('now'));
		$iA = 'actividad_id';
		$iU = 'usuario_id';
		$iFc = 'fecha_de_creacion';

		$actividadesUser	=	[
			[	$iA	=>	2,	$iU	=>	1,	$iFc => $fdc],
			[	$iA	=>	5,	$iU	=>	2,	$iFc => $fdc],
			[	$iA	=>	2,	$iU	=>	3,	$iFc => $fdc],
			[	$iA	=>	1,	$iU	=>	4,	$iFc => $fdc],
			[	$iA	=>	2,	$iU	=>	4,	$iFc => $fdc],
			[	$iA	=>	3,	$iU	=>	4,	$iFc => $fdc],
			[	$iA	=>	9,	$iU	=>	4,	$iFc => $fdc],
			[	$iA	=>	1,	$iU	=>	5,	$iFc => $fdc],
			[	$iA	=>	2,	$iU	=>	5,	$iFc => $fdc],
			[	$iA	=>	3,	$iU	=>	5,	$iFc => $fdc],
			[	$iA	=>	9,	$iU	=>	5,	$iFc => $fdc],
			[	$iA	=>	1,	$iU	=>	6,	$iFc => $fdc],
			[	$iA	=>	2,	$iU	=>	6,	$iFc => $fdc],
			[	$iA	=>	3,	$iU	=>	6,	$iFc => $fdc],
			[	$iA	=>	9,	$iU	=>	6,	$iFc => $fdc]
		];

		DB::table('usuario_actividad')->insert(	$actividadesUser);

  }
}
