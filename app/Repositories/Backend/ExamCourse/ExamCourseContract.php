<?php namespace App\Repositories\Backend\ExamCourse;

/**
 * Interface UserContract
 * @package App\Repositories\ExamCourse
 */
interface ExamCourseContract {

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
    public function getExamCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_exam_edit = 0);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllExamCourses($order_by = 'id', $sort = 'asc', $f_exam_edit = 0);

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_exam_edit);

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

    public function add($question_id, $exam_id);
}