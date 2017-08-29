<?php namespace App\Repositories\Backend\Office;

/**
 * Interface UserContract
 * @package App\Repositories\Office
 */
interface OfficeContract {

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
    public function getOfficesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_OfficeController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllOffices($order_by = 'id', $sort = 'asc');

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