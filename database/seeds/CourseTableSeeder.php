<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

class CourseTableSeeder extends Seeder
{

	public function run()
	{

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if (env('DB_DRIVER') == 'mysql')
			DB::table('courses')->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE " . config('courses') . " CASCADE");

		$courses = [];

        $s = 1;
        for($i=1;$i<=110;$i++){
            $courses[] = [
                'subsection_id' => $s,
                'user_admin_id' => 1,
                'title' => 'Curso chamado ' . $i,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'course_content' => "<h3>Teste de titulo 1</h3><p></p><ul><li>Informação 1,&nbsp;Informação 1 ,&nbsp;Informação 1,&nbsp;Informação 1,&nbsp;Informação 1</li><li>Informação 2,&nbsp;Informação 1,&nbsp;Informação 1,&nbsp;Informação 1</li><li>Informação 3,&nbsp;Informação 1,&nbsp;, Informação 1, Informação 1, Informação 1<br></li><li>Informação 4, Informação 1, Informação 1, Informação 1<br></li><li>Informação 5, Informação 1, Informação 1, Informação 1, Informação 1<br></li><li>Informação 6, Informação 1, Informação 1<br></li><li>Informação 7, Informação 1, Informação 1, Informação 1<br></li></ul><p></p><h3>Teste de titulo 2</h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt",
                'slug' => str_slug('Curso chamado ' . $i),
                'price' => 4500,
                'video_ad_url' => 'https://vimeo.com/6004944',
                'discount_price' => 4100,
                'average_grade' => rand(1, 100),
                'orders_count' => rand(1, 300),
                'special_offer' => rand(0,1),
                'access_time' => rand(30,90),
                'workload' => rand(20,60),
                'featured' => rand(0,1),
                'is_active' => 1,
                'activation_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $s = ($s == 6) ? 1 : $s+1;
        }

		DB::table('courses')->insert($courses);

		if (env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
