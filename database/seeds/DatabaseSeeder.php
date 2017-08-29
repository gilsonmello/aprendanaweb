<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		if(env('DB_DRIVER')=='mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call(AccessTableSeeder::class);
		$this->call(NewsletterTableSeeder::class);
		$this->call(CityStateCountryTableSeeder::class);
		$this->call(SectionTableSeeder::class);
		$this->call(SubsectionTableSeeder::class);
		$this->call(ConfigTableSeeder::class);
		$this->call(TeacherStatementTableSeeder::class);
		$this->call(SectorTableSeeder::class);
		$this->call(LessonTableSeeder::class);
		$this->call(ContentsTableSeeder::class);
		$this->call(ContentsCommentsTableSeeder::class);
		$this->call(TicketTableSeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(CourseTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
		$this->call(OrderTableSeeder::class);
		$this->call(TeacherStatementTableSeeder::class);
		$this->call(LessonTableSeeder::class);
		$this->call(ContentsTableSeeder::class);
		$this->call(ContentsCommentsTableSeeder::class);
		$this->call(ExamDireitoAdministrativoSeeder::class);

		if(env('DB_DRIVER')=='mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		Model::reguard();
	}
}