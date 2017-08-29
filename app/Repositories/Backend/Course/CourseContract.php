<?php namespace App\Repositories\Backend\Course;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface CourseContract
{

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
    public function getCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_CourseController_title = '',
                                        $f_CourseController_active = '', $f_CourseController_featured = '',
                                        $f_CourseController_special_offer = '');

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getCoursesBySection($id, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCourses($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input);


    public function activate($id);

    public function deactivate($id);

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

    public function selectCourses($term = '', $order_by = 'title', $sort = 'asc');

    public function getCourses($order_by = 'id', $sort = 'asc', $f_CourseController_title = '',
                               $f_CourseController_active = '', $f_CourseController_featured = '', $f_CourseController_special_offer = '');


    public function cloneCourse($id);

}