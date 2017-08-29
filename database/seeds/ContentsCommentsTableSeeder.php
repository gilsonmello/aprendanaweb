<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class ContentsCommentsTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('content_comments')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('content_comments') . " CASCADE");

		//Add the master administrator, user id of 1
		$contentscomments = [
			[
				'contents_id' => DB::table('contents')->where('title', '=', 'Direito')->value('id'),
				'publisher_id' => DB::table('users')->where('id', '=', '1')->value('id'),
				'moderator_id' => DB::table('users')->where('id', '=', '1')->value('id'),
				'date' => Carbon::now(),
				'comment' => 'Direito',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		];

		DB::table('content_comments')->insert($contentscomments);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
