<?php namespace App\Repositories\Backend\Exam;

/**
 * Interface UserContract
 * @package App\Repositories\Exam
 */
interface ExamContract {

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
    public function getExamsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_ExamController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllExams($order_by = 'id', $sort = 'asc');

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
    public function updateFeaturedImg($id, $filename);

    /**
     * @param $id
     * @param $filename
     * @return
     */
    public function updateClassroomImg($id, $filename);


    public function getExamsSelect($order_by = 'id', $sort = 'asc');




}