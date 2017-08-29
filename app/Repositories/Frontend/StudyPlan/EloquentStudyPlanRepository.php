<?php namespace App\Repositories\Frontend\StudyPlan;

use App\StudyPlan;
use App\Exceptions\GeneralException;

/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentStudyPlanRepository implements StudyPlanContract {


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$studyPlan = StudyPlan::withTrashed()->find($id);

		if (! is_null($studyPlan)) return $studyPlan;

		throw new GeneralException('That studyPlan does not exist.');
	}

	public function create($input)
	{
		$studyPlan = new StudyPlan();
		$studyPlan->daily_time = $input['daily'];
		$studyPlan->associate($input['user']);
		if($studyPlan->save()){
			return $studyPlan;

		}
	}

	public function update($id, $input)
	{
		$studyPlan = $this->findOrThrowException($id);
		$studyPlan->daily_time = $input['daily'];
		if($studyPlan->save()) return $studyPlan;
	}

	public function findByUser($user_id)
	{
		$studyPlan = StudyPlan::where('user_id',$user_id)->first();
		if($studyPlan == null) return false;
		return $studyPlan;
	}
}