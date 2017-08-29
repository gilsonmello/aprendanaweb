<?php namespace App\Repositories\Backend\AskTheTeacher;

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

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAskTheTeachersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AskTheTeacherController_question = '', $f_AskTheTeacherController_is_replied = '2');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAskTheTeachers($order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAskTheTeachersNotActive($order_by = 'id', $sort = 'asc');

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

    /**
     * @param $id
     * @param $filename
     * @return
     */
    public function updateImg($id, $filename);

}