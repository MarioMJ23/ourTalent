<?php

use Illuminate\Database\Seeder;

class TiposDeActividadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()	{
    	$fdc = date('Y-m-d H:i:s',	strtotime('now'));
  		$it = 'tipo';
  		$iFc = 'fecha_de_creacion';

  		$tipos_de_actividad	=	[
				[	$it	=>	'Deportiva', $iFc => $fdc],
				[	$it	=>	'Cultural', $iFc => $fdc],
				[	$it	=>	'Recreativa o de integración', $iFc => $fdc]
			];

			DB::table('tipos_de_actividad')->insert(	$tipos_de_actividad);
    }
}
