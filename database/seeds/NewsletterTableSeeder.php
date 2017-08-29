<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class NewsletterTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('newsletters')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('newsletters') . " CASCADE");

		//Add the master administrator, user id of 1
		$newsletter = [
			[
				'name' => 'Adhemar Fontes',
				'email' => 'adhemarfontes@gmail.com',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		];

		DB::table('newsletters')->insert($newsletter);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
