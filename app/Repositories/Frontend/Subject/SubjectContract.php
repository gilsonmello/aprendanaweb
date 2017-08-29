<?php namespace App\Repositories\Frontend\Subject;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface SubjectContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);


}