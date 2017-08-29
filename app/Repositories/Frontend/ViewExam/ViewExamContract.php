<?php namespace App\Repositories\Frontend\ViewExam;

/**
 * Interface UserContract
 * @package App\Repositories\ViewExam
 */
interface ViewExamContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);
    public function findByEnrollmentAndQuestion($enrollment_id,$question_id);
    public function enrollmentHasViewExam($enrollment_id, $question_id);
    public function createViewExam($execution,$question,$max_view);
    public function findByExecutionAndQuestion($execution_id,$question_id);


}