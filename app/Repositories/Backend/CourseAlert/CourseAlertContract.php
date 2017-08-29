<?php namespace App\Repositories\Backend\CourseAlert;

/**
 * Interface UserContract
 * @package App\Repositories\CourseTeacher
 */
interface CourseAlertContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);



    public function getCoursesAlertsPaginated($per_page, $course_id, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCoursesAlerts($order_by = 'id', $sort = 'asc');

    public function getAllCoursesAlertsPerCourse($course, $order_by = 'id', $sort = 'asc') ;
    /**
     * @param $input
     * @return mixed
     */
    public function create( $input );

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