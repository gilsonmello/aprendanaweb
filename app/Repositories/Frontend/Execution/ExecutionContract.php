<?php namespace App\Repositories\Frontend\Execution;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface ExecutionContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function findEager($id);

    public function findByEnrollmentAndLesson($enrollment,$lesson);

    public function finish($execution);

    public function create($enrollment,$input);

    public function createForLesson($enrollment,$lesson, $attempt = 1);

    public function createForCourse($enrollment,$course,$attempt = 1);

    public function updateTime($id,$time,$questionExecution);

    public function updateOnlyTime($id,$time);

    public function updateLastQuestion($id,$question_execution);

    public function getPreviousAttempt($execution);

    public function getByUser($execution);

    public function updateGrade($execution, $rights);

    public function updateRating($execution,$rating);

    public function updateComment($execution,$comment);



    public function createOrUpdateTeacherRating($teacher, $execution,$rating_type,$rating);

}