<?php

use Illuminate\Database\Seeder;

class TallasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()	{
	    $fdc = date('Y-m-d H:i:s',	strtotime('now'));
			$iT = 'talla';
			$iTen	= 'talla_en';
			$iU = 'usuario_id';
			$iFc = 'fecha_de_creacion';

			$tallas	=	[
				[
					$iT	=>	2.04,
					$iTen	=>	6.69,	
					$iU		=>	1,
					$iFc => '2018-01-15 18:22:00'
				],
				[
					$iT	=>	2.04,
					$iTen	=>	6.69,	
					$iU		=>	1,
					$iFc => '2018-02-02 09:40:00'
				],
				[
					$iT	=>	2.04,
					$iTen	=>	6.69,	
					$iU		=>	1,
					$iFc => '2018-03-11 14:07:00'
				],
			];

			DB::table('tallas')->insert(	$tallas);

    }
}
