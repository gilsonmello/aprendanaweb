<?php namespace App\Repositories\Frontend\Lesson;

/**
 * Interface UserLesson
 * @package App\Repositories\Lesson
 */
interface LessonContract {

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
    public function getsLessonPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllLessons($order_by = 'id', $sort = 'asc');

    public function getAllLessonsByModule($module_id, $order_by = 'sequence', $sort = 'asc');

}