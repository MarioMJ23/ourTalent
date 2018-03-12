<?php

use Illuminate\Database\Seeder;

class PesosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()	{
	    $fdc = date('Y-m-d H:i:s',	strtotime('now'));
			$iP = 'peso';
			$iPen	= 'peso_en';
			$iU = 'usuario_id';
			$iFc = 'fecha_de_creacion';

			$pesos	=	[
				[
					$iP	=>	90,
					$iPen	=>	198.4,	
					$iU		=>	1,
					$iFc => '2018-01-15 18:22:00'
				],
				[
					$iP	=>	92,
					$iPen	=>	202.8,	
					$iU		=>	1,
					$iFc => '2018-02-02 09:40:00'
				],
				[
					$iP	=>	96,
					$iPen	=>	211.6,	
					$iU		=>	1,
					$iFc => '2018-03-11 14:07:00'
				],
			];

			DB::table('pesos')->insert(	$pesos);
    }
}
