<?php namespace App\Repositories\Frontend\Criterion;

/**
 * Interface UserContract
 * @package App\Repositories\CourseTeacher
 */
interface CriterionContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function getAllCriteria($order_by = 'id', $sort = 'asc');


}