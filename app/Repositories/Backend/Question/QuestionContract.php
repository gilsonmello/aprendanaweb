<?php namespace App\Repositories\Backend\Question;

/**
 * Interface UserContract
 * @package App\Repositories\Question
 */
interface QuestionContract {

    /**
     * @param $answer_type
     * @param $discipline
     * @param $year
     * @param $teacher
     * @param $source
     * @return mixed
     */
    public function allFilteredQuestions($answer_type, $discipline, $year, $teacher, $source, $duplicated = null);

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
    public function getQuestionsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_QuestionController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllQuestions($order_by = 'id', $sort = 'asc');

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

    public function updateImage($id, $filename);
}