<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class ModuleTableSeeder extends Seeder
{

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table('modules')->truncate();
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('modules') . " CASCADE");

        $modules = [];

        for($i=1;$i<=12;$i++){
            $modules[] = [
                'subsection_id' => 1,
                'name' => 'Modulo chamado ' . $i,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'video_ad_url' => 'https://vimeo.com/6004944',
                'price' => 4500,
                'discount_price' => 4100,
                'sequence' => $i,
                'is_sold_separately' => 1,
                'is_active' => 1,
                'course_id' => 1,
                'activation_date' => Carbon::now()
            ];
        }

        DB::table('modules')->insert($modules);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
