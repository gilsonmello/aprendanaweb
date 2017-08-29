<?php namespace App\Repositories\Frontend\Criterion;

use App\Criterion;


/**
 * Class EloquentCourseTeacherRepository
 * @package App\Repositories\CourseTeacher
 */
class EloquentCriterionRepository implements CriterionContract {


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
        $criterion = Criterion::all()->find($id);

		if (! is_null($criterion)) return $criterion;

		throw new GeneralException('That criterion does not exist.');
	}

    public function getAllCriteria($order_by = 'id', $sort = 'asc') {
        return Criterion::orderBy($order_by, $sort)->get();
    }




}