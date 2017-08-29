<?php namespace App\Repositories\Backend\WorkshopActivity;

/**
 * Interface UserContract
 * @package App\Repositories\WorkshopActivity
 */
interface WorkshopActivityContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $type_report
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getActivityReport($group_report, $workshop);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getWorkshopActivitysPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopActivitys($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $workshop_id);

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