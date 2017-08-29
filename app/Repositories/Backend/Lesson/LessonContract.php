<?php namespace App\Repositories\Backend\Lesson;

/**
 * Interface UserContract
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
    public function getLessonsPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllLessons($order_by = 'id', $sort = 'asc');
    public function selectLessons($term = '', $course_id = null, $order_by = 'name', $sort = 'asc');


    public function basicCreate($module_id, $title, $sequence, $duration);


    public function getAllModuleLessons($module_id, $order_by= 'id', $sort = 'asc');
    /**
     * @param $input
     * @return mixed
     */
    public function create($input);



    public function linkTeacher($id,$teacher,$percentage);
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


    public function getMaxSequence($module_id);

}