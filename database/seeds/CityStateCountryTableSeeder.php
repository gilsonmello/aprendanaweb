<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class CityStateCountryTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql') {
			DB::table('states')->truncate();
			DB::table('countries')->truncate();
		}
		else { //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('states') . " CASCADE");
			DB::statement("TRUNCATE TABLE " . config('countries') . " CASCADE");
		}

		$country = [
			[
				'name' => 'Brasil',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		];

		DB::table('countries')->insert($country);

		$state = [['name' => 'Rondônia','short' => 'RO','id' => 	11	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Acre','short' => 'AC','id' => 	12	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Amazonas','short' => 'AM','id' => 	13	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Roraima','short' => 'RR','id' => 	14	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Pará','short' => 'PA','id' => 	15	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Amapá','short' => 'AP','id' => 	16	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Tocantins','short' => 'TO','id' => 	17	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Maranhão','short' => 'MA','id' => 	21	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Piauí','short' => 'PI','id' => 	22	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Ceará','short' => 'CE','id' => 	23	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Rio Grande do Norte','short' => 'RN','id' => 	24	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Paraiba','short' => 'PB','id' => 	25	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Pernambuco','short' => 'PE','id' => 	26	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Alagoas','short' => 'AL','id' => 	27	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Sergipe','short' => 'SE','id' => 	28	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Bahia','short' => 'BA','id' => 	29	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Minas Gerais','short' => 'MG','id' => 	31	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Espírito Santo','short' => 'ES','id' => 	32	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Rio de Janeiro','short' => 'RJ','id' => 	33	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'São Paulo','short' => 'SP','id' => 	35	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Paraná','short' => 'PR','id' => 	41	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Santa Catarina','short' => 'SC','id' => 	42	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Rio Grande do Sul','short' => 'RS','id' => 	43	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Mato Grosso do Sul','short' => 'MS','id' => 	50	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Mato Grosso','short' => 'MT','id' => 	51	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Goais','short' => 'GO','id' => 	52	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);
		$state = [['name' => 'Distrito Federal','short' => 'DF','id' => 	53	, 'country_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		DB::table('states')->insert($state);


		//$city = [['name' => 'Salvador','id_state' => 1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()]];
		//DB::table('cities')->insert($city);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
