<?php namespace App\Repositories\Backend\Preenrollment;

/**
 * Interface UserContract
 * @package App\Repositories\Preenrollment
 */
interface PreenrollmentContract {

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
    public function getPreenrollmentsPaginated($per_page = NULL, $partner_id, $f_PreenrollmentController_studentname = '', $f_PreenrollmentController_status = '', $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPreenrollments($partner_id, $f_PreenrollmentController_studentname = '', $f_PreenrollmentController_status = '', $order_by = 'id', $sort = 'asc') ;

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
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPendingPreenrollmentsPerStudentgroup($studentgroup_id, $order_by = 'id', $sort = 'asc');

}