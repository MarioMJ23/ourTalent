<?php

use Illuminate\Database\Seeder;

class TiposDeSangreTableSeeder extends Seeder
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

  		$tipos_de_sangre	=	[
				[	$it	=>	'A+', $iFc => $fdc],
				[	$it	=>	'A-', $iFc => $fdc],
				[	$it	=>	'B+', $iFc => $fdc],
				[	$it	=>	'B-', $iFc => $fdc],
				
				[	$it	=>	'AB+', $iFc => $fdc],
				[	$it	=>	'AB-', $iFc => $fdc],
				[	$it	=>	'O+', $iFc => $fdc],
				[	$it	=>	'O-', $iFc => $fdc]
			];

			DB::table('tipos_de_sangre')->insert(	$tipos_de_sangre);
    }
}
