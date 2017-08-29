<?php namespace App\Repositories\Backend\MyWorkshopActivity;

/**
 * Interface UserContract
 * @package App\Repositories\MyWorkshopActivity
 */
interface MyWorkshopActivityContract {

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
    public function getMyWorkshopActivitysPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllMyWorkshopActivitys($order_by = 'id', $sort = 'asc');

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