<?php namespace App\Repositories\Frontend\Module;

use App\Module;
use App\TeacherLesson;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentModuleRepository implements ModuleContract {


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
        $Module = Module::withTrashed()->find($id);

		if (! is_null($Module)) return $Module;

		throw new GeneralException('That module does not exist.');
	}

	public function getLessonsPerTeacherPerModule($module){
		$teachers = TeacherLesson::join('lessons', 'lessons.id', '=', 'lesson_teachers.lesson_id')
			->join('users', 'users.id', '=', 'lesson_teachers.teacher_id')
			->where('lessons.module_id', '=', $module->id)
			->whereNull('lessons.deleted_at')
			->whereNull('users.deleted_at')
			->groupBy('users.name',  'users.id' , 'users.photo', 'users.slug', 'users.resume')
			->select( 'users.name as name' ,  'users.id as id' , 'users.photo as photo', 'users.slug as slug', 'users.resume as resume', DB::raw('count(*) as lesson_teachers'))
			->orderBy('users.name','asc')->get();
		return $teachers;
	}

	public function getAllModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc') {
		$query = Module::where('course_id', '=', $course->id);
		return $query->orderBy($order_by, $sort)->get();
	}



}