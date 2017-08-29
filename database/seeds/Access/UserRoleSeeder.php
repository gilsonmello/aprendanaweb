<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder {

	public function run() {

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if(env('DB_DRIVER') == 'mysql')
			DB::table(config('access.assigned_roles_table'))->truncate();
		else //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE ".config('access.assigned_roles_table')." CASCADE");

		//Attach admin and teacher role to admin user
		$user_model = config('auth.model');
		$user_model = new $user_model;
		$user_model::find(1)->attachRoles([1]);

		//Attach teacher role to teachers users
		$user_model = config('auth.model');
		$user_model = new $user_model;
		$user_model::find(2)->attachRole(2);

        $user_model = config('auth.model');
        $user_model = new $user_model;
        $user_model::find(3)->attachRole(2);

        //Attach student role to student user
        $user_model = config('auth.model');
        $user_model = new $user_model;
        $user_model::find(4)->attachRole(3);

		$user_model = config('auth.model');
		$user_model = new $user_model;
		$user_model::find(5)->attachRole(3);

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}