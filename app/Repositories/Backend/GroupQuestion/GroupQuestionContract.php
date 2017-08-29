<?php namespace App\Repositories\Backend\GroupQuestion;

/**
 * Interface UserContract
 * @package App\Repositories\GroupQuestion
 */
interface GroupQuestionContract {

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
    public function getGroupQuestionsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_group_edit = 0);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllGroupQuestions($order_by = 'id', $sort = 'asc', $f_group_edit = 0);

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_group_edit);

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

    public function nextSequence($groupid);

    public function changeSequence($groupid, $newsequence);

    public function add($question_id, $group_id);

    public function getThemesOccurence($groupQuestion);
    public function getSubthemesOccurence($groupQuestion);
    public function getOriginalsOccurence($groupQuestion);
}