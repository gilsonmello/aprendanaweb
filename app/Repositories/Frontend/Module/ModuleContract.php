<?php namespace App\Repositories\Frontend\Module;

/**
 * Interface UserLesson
 * @package App\Repositories\Lesson
 */
interface ModuleContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function getLessonsPerTeacherPerModule($module_id);

    public function getAllModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc');
}