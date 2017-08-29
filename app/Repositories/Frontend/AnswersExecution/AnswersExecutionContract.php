<?php namespace App\Repositories\Frontend\AnswersExecution;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface AnswersExecutionContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function create($question_execution, $answers, $is_right);

    public function update($answer_execution, $answers, $is_right);

}