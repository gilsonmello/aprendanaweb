<?php namespace App\Repositories\Backend\Banner;

/**
 * Interface UserContract
 * @package App\Repositories\Banner
 */
interface BannerContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @param string $carousel
     * @param string $is_active
     * @return mixed
     */
    public function getBannersPaginated($per_page, $order_by = 'id', $sort = 'asc', $carousel = '', $is_active = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @param int $carousel
     * @return mixed
     */
    public function getAllBanners($order_by = 'id', $sort = 'asc', $carousel = null);

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
     * @param $filename
     * @return
     */
    public function updateImg($id, $filename);

}