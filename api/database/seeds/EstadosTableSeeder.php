<?php

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()	{
  		$fdc = date('Y-m-d H:i:s',	strtotime('now'));
  		$iE = 'estado';
  		$iFc = 'fecha_de_creacion';
  		$iPi = 'pais_id';
  		$iC = 'codigo';
    	$estados = [
		[$iE	=>	'Aguascalientes',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'AGU'],
		[$iE	=>	'Baja California',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'BCN'],
		[$iE	=>	'Baja California Sur',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'BCS'],
		[$iE	=>	'Campeche',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'CAM'],
		[$iE	=>	'Coahuila de Zaragoza',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'COA'],
		[$iE	=>	'Colima',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'COL'],
		[$iE	=>	'Chiapas',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'CHP'],
		[$iE	=>	'Chihuahua',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'CHH'],
		[$iE	=>	'Ciudad de México',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'CMX'],
		[$iE	=>	'Durango',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'DUR'],
		[$iE	=>	'Guanajuato',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'GUA'],
		[$iE	=>	'Guerrero',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'GRO'],
		[$iE	=>	'Hidalgo',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'HID'],
		[$iE	=>	'Jalisco',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'JAL'],
		[$iE	=>	'México',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'MEX'],
		[$iE	=>	'Michoacán de Ocampo',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'MIC'],
		[$iE	=>	'Morelos',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'MOR'],
		[$iE	=>	'Nayarit',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'NAY'],
		[$iE	=>	'Nuevo León',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'NLE'],
		[$iE	=>	'Oaxaca de Juárez',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'OAX'],
		[$iE	=>	'Puebla',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'PUE'],
		[$iE	=>	'Querétaro',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'QUE'],
		[$iE	=>	'Quintana Roo',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'ROO'],
		[$iE	=>	'San Luis Potosí',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'SLP'],
		[$iE	=>	'Sinaloa',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'SIN'],
		[$iE	=>	'Sonora',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'SON'],
		[$iE	=>	'Tabasco',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'TAB'],
		[$iE	=>	'Tamaulipas',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'TAM'],
		[$iE	=>	'Tlaxcala',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'TLA'],
		[$iE	=>	'Veracruz de Ignacio de la Llave',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'VER'],
		[$iE	=>	'Yucatán',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'YUC'],
		[$iE	=>	'Zacatecas',	$iPi	=>	147,	$iFc	=>	$fdc, $iC	=>	'ZAC'],
		[$iE	=>	ucwords(strtolower('ALABAMA')),	$iC	=>	'AL',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('ALASKA')),	$iC	=>	'AK',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('ARIZONA')),	$iC	=>	'AZ',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('ARKANSAS')),	$iC	=>	'AR',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('CALIFORNIA')),	$iC	=>	'CA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NORTH CAROLINA')),	$iC	=>	'NC',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('SOUTH CAROLINA')),	$iC	=>	'SC',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('COLORADO')),	$iC	=>	'CO',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('CONNECTICUT')),	$iC	=>	'CT',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NORTH DAKOTA')),	$iC	=>	'ND',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('SOUTH DAKOTA')),	$iC	=>	'SD',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('DELAWARE')),	$iC	=>	'DE',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('FLORIDA')),	$iC	=>	'FL',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('GEORGIA')),	$iC	=>	'GA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('HAWAI')),	$iC	=>	'HI',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('IDAHO')),	$iC	=>	'ID',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('ILLINOIS')),	$iC	=>	'IL',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('INDIANA')),	$iC	=>	'IN',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('IOWA')),	$iC	=>	'IA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('KANSAS')),	$iC	=>	'KS',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('KENTUCKY')),	$iC	=>	'KY',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('LUISIANA')),	$iC	=>	'LA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MAINE')),	$iC	=>	'ME',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MARYLAND')),	$iC	=>	'MD',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MASSACHUSETTS')),	$iC	=>	'MA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MICHIGAN')),	$iC	=>	'MI',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MINNESOTA')),	$iC	=>	'MN',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MISSISSIPPI')),	$iC	=>	'MS',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MISSOURI')),	$iC	=>	'MO',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('MONTANA')),	$iC	=>	'MT',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NEBRASKA')),	$iC	=>	'NE',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NEVADA')),	$iC	=>	'NV',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NEW JERSEY')),	$iC	=>	'NJ',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NEW YORK')),	$iC	=>	'NY',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NEW HAMPSHIRE')),	$iC	=>	'NH',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('NEW MEXICO')),	$iC	=>	'NM',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('OHIO')),	$iC	=>	'OH',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('OKLAHOMA')),	$iC	=>	'OK',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('OREGON')),	$iC	=>	'OR',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('PENNSYLVANIA')),	$iC	=>	'PA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('RHODE ISLAND')),	$iC	=>	'RI',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('TENNESSEE')),	$iC	=>	'TN',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('TEXAS')),	$iC	=>	'TX',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('UTAH')),	$iC	=>	'UT',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('VERMONT')),	$iC	=>	'VT',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('VIRGINIA')),	$iC	=>	'VA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('WEST VIRGINIA')),	$iC	=>	'WV',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('WASHINGTON')),	$iC	=>	'WA',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('WISCONSIN')),	$iC	=>	'WI',	$iFc	=>	$fdc,	$iPi	=>	70],
		[$iE	=>	ucwords(strtolower('WYOMING')),	$iC	=>	'WY',	$iFc	=>	$fdc,	$iPi	=>	70]
	];

			DB::table('estados')->insert(	$estados);
    }
}
