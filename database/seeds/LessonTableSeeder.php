<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class LessonTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('lessons')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('lessons') . " CASCADE");

		//Add the master administrator, user id of 1
        $lessons = [];
        $m = 1;
        for($i=1;$i<=60;$i++) {
            $lessons[] = [
                    'title' => 'Aula '.$i,
                    'sequence' => $i,
                    'module_id' => $m,
                    'price' => 42.00,
                    'discount_price' => 38.00,
                    'description' => 'NO NO NO NO NO NO NO NO NO NO NO',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            if(($i % 5) == 0) $m++;
            //$m = ($i % 12) + 1;
        }

		DB::table('lessons')->insert($lessons);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
