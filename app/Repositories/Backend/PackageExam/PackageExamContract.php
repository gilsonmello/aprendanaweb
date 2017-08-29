<?php namespace App\Repositories\Backend\PackageExam;

/**
 * Interface UserContract
 * @package App\Repositories\PackageExam
 */
interface PackageExamContract {

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
    public function getPackageExamsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_package_edit = 0);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPackageExams($order_by = 'id', $sort = 'asc', $f_package_edit = 0);

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_package_edit);

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

    public function add($question_id, $package_id);
}