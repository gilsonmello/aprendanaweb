<?php namespace App\Repositories\Backend\Advertisingpartner;

/**
 * Interface UserContract
 * @package App\Repositories\Advertisingpartner
 */
interface AdvertisingpartnerContract {

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
    public function getAdvertisingpartnersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AdvertisingpartnerController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAdvertisingpartners($order_by = 'id', $sort = 'asc');

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