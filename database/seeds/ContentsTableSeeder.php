<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class ContentsTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('contents')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('contents') . " CASCADE");

		//Add the master administrator, user id of 1
		$contents = [
			[
				'lesson_id' => 1,
				'title' => 'Direito',
				'url' => 'Direito',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		];

		DB::table('contents')->insert($contents);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}