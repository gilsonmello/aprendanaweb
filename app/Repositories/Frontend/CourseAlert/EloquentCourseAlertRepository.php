<?php namespace App\Repositories\Frontend\CourseAlert;

use App\Course;
use App\CourseAlert;
use App\Exceptions\GeneralException;
use App\Repositories\Frontend\CourseAlert\CourseAlertContract;
use App\User;

/**
 * Class EloquentCourseAlertRepository
 * @package App\Repositories\CourseAlert
 */
class EloquentCourseAlertRepository implements CourseAlertContract {


    public function getAllCoursesAlertsPerCourse($course, $order_by = 'date', $sort = 'desc') {
        $query = CourseAlert::where('course_id', '=', $course->id)->orWhereNull('course_id');
        return $query->orderBy($order_by, $sort)->get();
    }



}