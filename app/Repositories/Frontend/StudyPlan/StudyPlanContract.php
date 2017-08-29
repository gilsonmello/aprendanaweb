<?php namespace App\Repositories\Frontend\StudyPlan;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface StudyPlanContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function create($input);

    public function update($id,$input);

    public function findByUser($user_id);

}