<?php namespace App\Repositories\Backend\Package;

/**
 * Interface UserContract
 * @package App\Repositories\Package
 */
interface PackageContract {

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
    public function getPackagesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_PackageController_title = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPackages($order_by = 'id', $sort = 'asc');

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPackagesBySection($id, $order_by = 'id', $sort = 'asc');

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