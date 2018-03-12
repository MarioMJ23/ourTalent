<?php

use Illuminate\Database\Seeder;

class TiposDeArchivoTableSeeder extends Seeder
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

  		$tipos_de_archivo	=	[
				[	$it	=>	'Imágenes', $iFc => $fdc],
				[	$it	=>	'Videos', $iFc => $fdc],
				[	$it	=>	'Audios', $iFc => $fdc]
			];

			DB::table('tipos_de_archivo')->insert(	$tipos_de_archivo);
    }
}
