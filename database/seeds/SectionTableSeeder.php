<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class SectionTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('sections')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('sections') . " CASCADE");

		//Add the master administrator, user id of 1
		$sections = [
			[
				'name' => 'Carreira Jurídica',
                'slug' => str_slug('Carreira Jurídica'),
                'color' => '#0ab567',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
            [
                'name' => 'Combinadas',
                'slug' => str_slug('Combinadas'),
                'color' => '#e85353',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Concursos',
                'slug' => str_slug('Concursos'),
                'color' => '#797cff',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Isoladas',
                'slug' => str_slug('Isoladas'),
                'color' => '#d78dd7',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Novo CPC',
                'slug' => str_slug('Novo CPC'),
                'color' => '#c5d95a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Temas',
                'slug' => str_slug('Temas'),
                'color' => '#dcb61e',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
		];

		DB::table('sections')->insert($sections);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
