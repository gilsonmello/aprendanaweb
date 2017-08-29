<?php namespace App\Repositories\Backend\Enrollment;

/**
 * Interface UserContract
 * @package App\Repositories\Enrollment
 */
interface EnrollmentContract {
    
    /**
     * Função que retorna todas as matrículas do curso que o coordenador logado tem acesso
     */
    public function getEnrollmentsForCoordinators($per_page, $name = '', $course_id = NULL, $date_begin = NULL, $date_end = NULL, $released_for_certification = NULL);
    
    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function getCoursesPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc');

    public function getModulesPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc');

    public function getLessonsPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc');

    public function getExamsPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllEnrollments($order_by = 'name', $sort = 'asc');

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

    /**
     * @param $id
     * @return mixed
     */
    public function deactivated($id);

    /**
     * @param $id
     * @return mixed
     */
    public function activated($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getEnrollmentsTestPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function createTest($input);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getEnrollmentsSaapInCoursePaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function createSaapInCourse($input);

    public function getAllEnrollmentWithCoupon($f_EnrollmentController_coupon, $f_EnrollmentController_date_begin, $f_EnrollmentController_date_end, $order_by = 'id', $sort = 'asc');
}