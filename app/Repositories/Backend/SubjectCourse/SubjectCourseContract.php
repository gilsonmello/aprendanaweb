<?php namespace App\Repositories\Backend\SubjectCourse;

/**
 * Interface UserContract
 * @package App\Repositories\SubjectCourse
 */
interface SubjectCourseContract {

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
    public function getSubjectCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_subject_edit = 0);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSubjectCourses($order_by = 'id', $sort = 'asc', $f_subject_edit = 0);

    public function getAllSubjectCoursesConference();
    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_subject_edit);

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

    public function add($course_id, $exam_id, $subject_id);
}