<?php namespace App\Repositories\Frontend\CourseTeacher;

/**
 * Interface UserContract
 * @package App\Repositories\CourseTeacher
 */
interface CourseTeacherContract {

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
    public function getCourseTeachersPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCourseTeachers($order_by = 'id', $sort = 'asc');

    public function getAllCourseTeachersPerCourse($course, $order_by = 'id', $sort = 'asc') ;

    public function getAllCourseTeachersPerTeacher($teacher) ;

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