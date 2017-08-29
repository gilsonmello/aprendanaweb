<?php namespace App\Repositories\Frontend\CourseCalendar;

use App\Course;
use App\CourseCalendar;
use App\Exceptions\GeneralException;
use App\Repositories\Frontend\CourseCalendar\CourseCalendarContract;
use App\User;

/**
 * Class EloquentCourseCalendarRepository
 * @package App\Repositories\CourseCalendar
 */
class EloquentCourseCalendarRepository implements CourseCalendarContract {


    public function getAllCoursesCalendarsPerCourse($course, $order_by = 'date', $sort = 'desc') {
        $query = CourseCalendar::where('course_id', '=', $course->id);
        return $query->orderBy($order_by, $sort)->get();
    }



}