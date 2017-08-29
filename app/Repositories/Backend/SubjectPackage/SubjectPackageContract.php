<?php namespace App\Repositories\Backend\SubjectPackage;

/**
 * Interface UserContract
 * @package App\Repositories\SubjectCourse
 */
interface SubjectPackageContract {

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
    public function getSubjectPackagesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_subject_edit = 0);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSubjectPackages($order_by = 'id', $sort = 'asc', $f_subject_edit = 0);

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_subject_edit);

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

    public function add($package_id, $exam_id, $subject_id);
}