<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class SubsectionTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('subsections')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('subsections') . " CASCADE");

		//Add the master administrator, user id of 1
		$subsection = [
			[
				'name' => 'Carreira Jurídica',
                'slug' => str_slug('Carreira Jurídica'),
				'section_id' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
            [
                'name' => 'Combinadas',
                'slug' => str_slug('Combinadas'),
                'section_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Concursos',
                'slug' => str_slug('Concursos'),
                'section_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Isoladas',
                'slug' => str_slug('Isoladas'),
                'section_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Novo CPC',
                'slug' => str_slug('Novo CPC'),
                'section_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Temas',
                'slug' => str_slug('Temas'),
                'section_id' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
		];

		DB::table('subsections')->insert($subsection);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
