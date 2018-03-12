<?php

use Illuminate\Database\Seeder;

class TiposDeUsuarioTableSeeder extends Seeder
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

  		$tipos_de_usuario	=	[
				[	$it	=>	'Administrador', $iFc => $fdc],
				[	$it	=>	'Institución', $iFc => $fdc],
				[	$it	=>	'Usuario', $iFc => $fdc]
			];

			DB::table('tipos_de_usuario')->insert(	$tipos_de_usuario);
    }
}
