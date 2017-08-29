<?php namespace App\Repositories\Backend\View;

/**
 * Interface UserContract
 * @package App\Repositories\View
 */
interface ViewContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function getViewCoursePerStudent($f_ViewController_student_id, $f_ViewController_course_id);

    public function getViewModulePerStudent($f_ViewController_student_id, $f_ViewController_module_id);

    public function getViewLessonPerStudent($f_ViewController_student_id, $f_ViewController_lesson_id);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllViews($order_by = 'name', $sort = 'asc');

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