<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class TicketTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('tickets')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('tickets') . " CASCADE");

		//Add the master administrator, user id of 1
		$ticket = [
			[
				'user_student_id' => 4,
				'sector_id' => 1,
				'message' => 'Não estou conseguindo lbalblbal bla balba l balb alblabla',
				'date_dead_line_reply' => Carbon::now(),
				'is_replied' => 0,
				'is_finished' => 0,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		];

		DB::table('tickets')->insert($ticket);

		//Add the master administrator, user id of 1
		$ticket = [
			[
				'user_student_id' => 4,
				'sector_id' => 1,
				'message' => 'Video travou assistindo hjjdahdkgakgdkhgash',
				'date_dead_line_reply' => Carbon::now(),
				'is_replied' => 0,
				'is_finished' => 0,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		];

		DB::table('tickets')->insert($ticket);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
