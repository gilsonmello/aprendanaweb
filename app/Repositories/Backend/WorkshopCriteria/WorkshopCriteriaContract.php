<?php namespace App\Repositories\Backend\WorkshopCriteria;

/**
 * Interface UserContract
 * @package App\Repositories\WorkshopCriteria
 */
interface WorkshopCriteriaContract {

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
    public function getWorkshopCriteriasPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopCriterias($order_by = 'id', $sort = 'asc');

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