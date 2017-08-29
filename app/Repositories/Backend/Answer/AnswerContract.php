<?php namespace App\Repositories\Backend\Answer;

/**
 * Interface UserContract
 * @package App\Repositories\Answer
 */
interface AnswerContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAnswersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnswerController_choice = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnswers($order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnswersByQuestion($question_id, $order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);


}