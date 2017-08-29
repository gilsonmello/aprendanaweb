<?php namespace App\Repositories\Backend\PackageTeacher;

/**
 * Interface UserContract
 * @package App\Repositories\PackageTeacher
 */
interface PackageTeacherContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);



    public function findByPackageAndTeacher($package,$teacher);
    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPackageTeachersPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPackageTeachers($order_by = 'id', $sort = 'asc');

    public function getAllPackageTeachersPerPackage($package, $order_by = 'id', $sort = 'asc') ;
    /**
     * @param $input
     * @return mixed
     */
    public function create($teacher,$package,$percentage);

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