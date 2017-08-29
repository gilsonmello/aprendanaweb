<?php namespace App\Repositories\Frontend\CourseCalendar;

/**
 * Interface UserContract
 * @package App\Repositories\CourseTeacher
 */
interface CourseCalendarContract {

    public function getAllCoursesCalendarsPerCourse($course, $order_by = 'id', $sort = 'asc') ;
}