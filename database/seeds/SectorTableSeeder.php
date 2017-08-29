<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class SectorTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('sectors')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('sectors') . " CASCADE");

		//Add the master administrator, user id of 1
		$sector = [
			[
				'name' => 'Setor Acadêmico',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'hours_to_reply' => 48,
				'message_finish' => 'Ticket finalziado'
			]
		];

		DB::table('sectors')->insert($sector);

		$sector = [
			[
				'name' => 'Setor Financeiro',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'hours_to_reply' => 48,
				'message_finish' => 'Ticket finalziado'
			]
		];

		DB::table('sectors')->insert($sector);

		$sector = [
			[
				'name' => 'Setor de Tecnologia',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'hours_to_reply' => 48,
				'message_finish' => 'Ticket finalziado'
			]
		];

		DB::table('sectors')->insert($sector);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
