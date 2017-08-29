<?php namespace App\Repositories\Frontend\Subject;

use App\Subject;
use App\Exceptions\GeneralException;

/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentSubjectRepository implements SubjectContract {


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$subject = Subject::withTrashed()->find($id);

		if (! is_null($subject)) return $subject;

		throw new GeneralException('That subject does not exist.');
	}

}