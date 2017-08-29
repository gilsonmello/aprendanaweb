<?php namespace App\Repositories\Backend\WorkshopGroupTutor;

/**
 * Interface UserContract
 * @package App\Repositories\WorkshopGroupTutor
 */
interface WorkshopGroupTutorContract {

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
    public function getWorkshopGroupTutorsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_WorkshopGroupTutorController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopGroupTutors($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $evaluation_group_id);

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