<?php namespace App\Repositories\Frontend\CourseAlert;

/**
 * Interface UserContract
 * @package App\Repositories\CourseTeacher
 */
interface CourseAlertContract {

    public function getAllCoursesAlertsPerCourse($course, $order_by = 'id', $sort = 'asc') ;
}