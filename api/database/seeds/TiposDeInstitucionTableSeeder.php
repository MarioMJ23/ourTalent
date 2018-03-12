<?php

use Illuminate\Database\Seeder;

class TiposDeInstitucionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()	{
    	$fdc = date('Y-m-d H:i:s',	strtotime('now'));
  		$it = 'tipo';
  		$iD = 'descripcion';
  		$iFc = 'fecha_de_creacion';

  		$tipos_de_institucion	=	[
				[	$it	=>	'Educativa', $iD	=>	'Cualquier institución que brinde servicios dedicados a impartir educación a cualquier nivel, ej. (Preparatoria, Universidad, Collages, etc.).',	$iFc => $fdc],
				[	$it	=>	'Comerciales', $iD	=>	'Cualquier institución que tenga fines lucrativos al brindar un servicio o espectáculo, ej. (Equipos profesionales de algún deporte, Agencias para personal artístico, etc.).',	$iFc => $fdc],
				[	$it	=>	'Social', $iD	=>	'Cualquier institución que tenga fines recreativos o de integrar al prestar un servicio o espectáculo, ej. (Organizaciones de apoyo a la comunidad, etc.).',	$iFc => $fdc]
			];

			DB::table('tipos_de_institucion')->insert(	$tipos_de_institucion);
    }
}
