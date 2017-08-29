<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class TagsTableSeeder extends Seeder
{

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table('tags')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('tags') . " CASCADE");

        //Add basic tags
        $tags = [
            [
                'name' => 'Direito Civil',
                'description' => 'Direito Civil',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Direito do Consumidor',
                'description' => 'Direito do Consumidor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Direitos Humanos',
                'description' => 'Direitos Humanos',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Direitos Penal',
                'description' => 'Direitos Penal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('tags')->insert($tags);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
