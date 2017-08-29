<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class ArticleTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('articles')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('articles') . " CASCADE");

		$articles = [];

        for($i=1;$i<=10;$i++){
            $articles[] = [
                'title' => 'Artigo chamado ' . $i,
                'date' => '2014-0'.$i.'-01',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'slug' => str_slug('Artigo chamado ' . $i),
                'status' => 1,
                'activation_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

		DB::table('articles')->insert($articles);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
