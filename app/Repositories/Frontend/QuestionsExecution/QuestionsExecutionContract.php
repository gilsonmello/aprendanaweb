<?php namespace App\Repositories\Frontend\QuestionsExecution;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface QuestionsExecutionContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function findNext($id);

    public function create($user,$input);

    public function updateTime($object, $time);

    public function setGrade($object, $grade);

    public function getQuestionsFromExecution($execution);

    public function getQuestionsNotAnswered( $execution );

    public function getSiblingsCount($execution, $includeSelf);

    public function findPrev($id);

}