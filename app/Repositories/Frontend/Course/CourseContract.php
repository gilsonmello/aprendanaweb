<?php

namespace App\Repositories\Frontend\Course;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface CourseContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function findEager($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCourses($order_by = 'id', $sort = 'asc');

    public function incrementClick($course, $count = 1);

    public function getCourseWithExamsAgregated();
    public function getExamsAgregatedCourse($course_id);
    public function getCourseByTags($term) ;
}
