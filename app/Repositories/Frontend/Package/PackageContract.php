<?php namespace App\Repositories\Frontend\Package;

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
    public function getPackagesPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPackages($order_by = 'id', $sort = 'asc');


    public function getRelatedPackages($package,$limit);

    public function incrementClick($package, $count = 1);
    public function getPackageByTags($term);
}