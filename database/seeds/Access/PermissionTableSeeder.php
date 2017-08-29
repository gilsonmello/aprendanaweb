<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionTableSeeder extends Seeder {

	public function run() {

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if(env('DB_DRIVER') == 'mysql')
		{
			DB::table(config('access.permissions_table'))->truncate();
			DB::table(config('access.permission_role_table'))->truncate();
			DB::table(config('access.permission_user_table'))->truncate();
		} else { //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE ".config('access.permissions_table')." CASCADE");
			DB::statement("TRUNCATE TABLE ".config('access.permission_role_table')." CASCADE");
			DB::statement("TRUNCATE TABLE ".config('access.permission_user_table')." CASCADE");
		}

		$permission_model = config('access.permission');

		$viewBackend = new $permission_model;
		$viewBackend->name = 'view_backend';
		$viewBackend->display_name = 'Acesso ao Painel';
		$viewBackend->system = true;
		$viewBackend->created_at = Carbon::now();
		$viewBackend->updated_at = Carbon::now();
		$viewBackend->save();

        $article= new $permission_model;
        $article->name = 'articles';
        $article->display_name = 'Artigos';
        $article->system = false;
        $article->created_at = Carbon::now();
        $article->updated_at = Carbon::now();
        $article->save();

        $course= new $permission_model;
        $course->name = 'courses';
        $course->display_name = 'Cursos';
        $course->system = false;
        $course->created_at = Carbon::now();
        $course->updated_at = Carbon::now();
        $course->save();

        $module= new $permission_model;
        $module->name = 'modules';
        $module->display_name = 'Disciplinas';
        $module->system = false;
        $module->created_at = Carbon::now();
        $module->updated_at = Carbon::now();
        $module->save();

        $coupon= new $permission_model;
        $coupon->name = 'coupons';
        $coupon->display_name = 'Cupons';
        $coupon->system = false;
        $coupon->created_at = Carbon::now();
        $coupon->updated_at = Carbon::now();
        $coupon->save();


        $faqCategory= new $permission_model;
        $faqCategory->name = 'faq_category';
        $faqCategory->display_name = 'Categoria FAQ';
        $faqCategory->system = false;
        $faqCategory->created_at = Carbon::now();
        $faqCategory->updated_at = Carbon::now();
        $faqCategory->save();

        $tag= new $permission_model;
        $tag->name = 'tags';
        $tag->display_name = 'Tags';
        $tag->system = false;
        $tag->created_at = Carbon::now();
        $tag->updated_at = Carbon::now();
        $tag->save();

        $section = new $permission_model;
        $section->name = 'sections';
        $section->display_name = 'Seções';
        $section->system = false;
        $section->created_at = Carbon::now();
        $section->updated_at = Carbon::now();
        $section->save();

        $subsection = new $permission_model;
        $subsection->name = 'subsections';
        $subsection->display_name = 'Subseções';
        $subsection->system = false;
        $subsection->created_at = Carbon::now();
        $subsection->updated_at = Carbon::now();
        $subsection->save();

        $newsletter= new $permission_model;
        $newsletter->name = 'newsletters';
        $newsletter->display_name = 'Newsletter';
        $newsletter->system = false;
        $newsletter->created_at = Carbon::now();
        $newsletter->updated_at = Carbon::now();
        $newsletter->save();

        $faq= new $permission_model;
        $faq->name = 'faqs';
        $faq->display_name = 'FAQ';
        $faq->system = false;
        $faq->created_at = Carbon::now();
        $faq->updated_at = Carbon::now();
        $faq->save();

        $student= new $permission_model;
        $student->name = 'userstudents';
        $student->display_name = 'Alunos';
        $student->system = false;
        $student->created_at = Carbon::now();
        $student->updated_at = Carbon::now();
        $student->save();

        $city= new $permission_model;
        $city->name = 'cities';
        $city->display_name = 'Cidades';
        $city->system = false;
        $city->created_at = Carbon::now();
        $city->updated_at = Carbon::now();
        $city->save();

        $teacher= new $permission_model;
        $teacher->name = 'userteachers';
        $teacher->display_name = 'professores';
        $teacher->system = false;
        $teacher->created_at = Carbon::now();
        $teacher->updated_at = Carbon::now();
        $teacher->save();

        $teacher_statements= new $permission_model;
        $teacher_statements->name = 'teacherstatements';
        $teacher_statements->display_name = 'Comentário de Professores';
        $teacher_statements->system = false;
        $teacher_statements->created_at = Carbon::now();
        $teacher_statements->updated_at = Carbon::now();
        $teacher_statements->save();

        $lessons = new $permission_model;
        $lessons->name = 'lessons';
        $lessons->display_name = 'Aula';
        $lessons->system = false;
        $lessons->created_at = Carbon::now();
        $lessons->updated_at = Carbon::now();
        $lessons->save();

        $contents = new $permission_model;
        $contents->name = 'content';
        $contents->display_name = 'Conteúdo';
        $contents->system = false;
        $contents->created_at = Carbon::now();
        $contents->updated_at = Carbon::now();
        $contents->save();

        $contentComments = new $permission_model;
        $contentComments->name = 'content_comments';
        $contentComments->display_name = 'Comentário';
        $contentComments->system = false;
        $contentComments->created_at = Carbon::now();
        $contentComments->updated_at = Carbon::now();
        $contentComments->save();


        $config= new $permission_model;
        $config->name = 'configurations';
        $config->display_name = 'Configuração';
        $config->system = false;
        $config->created_at = Carbon::now();
        $config->updated_at = Carbon::now();
        $config->save();

            //Find the admin role give it all permissions
        $videos = new $permission_model;
            $videos->name = 'videos';
            $videos->display_name = 'Videos';
            $videos->system = true;
            $videos->created_at = Carbon::now();
            $videos->updated_at = Carbon::now();
            $videos->save();


            $sectors = new $permission_model;
            $sectors->name = 'sectors';
            $sectors->display_name = 'Setores';
            $sectors->system = true;
            $sectors->created_at = Carbon::now();
            $sectors->updated_at = Carbon::now();
            $sectors->save();

        $tickets = new $permission_model;
        $tickets->name = 'tickets';
        $tickets->display_name = 'Tickets';
        $tickets->system = true;
        $tickets->created_at = Carbon::now();
        $tickets->updated_at = Carbon::now();
        $tickets->save();

        $orders = new $permission_model;
        $orders->name = 'orders';
        $orders->display_name = 'Pedidos';
        $orders->system = true;
        $orders->created_at = Carbon::now();
        $orders->updated_at = Carbon::now();
        $orders->save();

        //Find the admin role give it all permissions
        $role_model = config('access.role');
        $role_model = new $role_model;
        $admin = $role_model::first();
        $admin->permissions()->sync(
            [
                $viewBackend->id,
                $videos->id,
                $article->id,
                $course->id,
                $module->id,
                $faq->id,
                $article->id,
                $section->id,
                $subsection->id,
                $newsletter->id,
                $coupon->id,
                $faqCategory->id,
                $tag->id,
                $student->id,
                $city->id,
                $teacher->id,
                $config->id,
                $teacher_statements->id,
                $sectors->id,
                $lessons ->id,
                $contents ->id,
                $contentComments -> id,
                $tickets->id,
                $orders->id,
            ]
        );

        //Find the admin role give it all permissions
        $role_model = config('access.role');
        $role_model = new $role_model;
        $teacher = $role_model::find(2);
        $teacher->permissions()->sync(
            [
                $viewBackend->id,
                $article->id
            ]
        );

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}