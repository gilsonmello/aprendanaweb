<?php namespace App\Repositories\Frontend\AskTheTeacher;

/**
 * Interface UserContract
 * @package App\Repositories\AskTheTeacher
 */
interface AskTheTeacherContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function getAskTheTeachersPerStudent($user_id, $order_by = 'id', $sort = 'desc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($question, $question_id, $lesson_id);


    public function getAskTheTeacherPerPartner($partner_id,$order_by = 'id',$sort = 'desc');

    public function getBySearch($term,$partners_id);

    public function createAskTheTutor($input);
}