<?php namespace App\Repositories\Backend\Workshop;

/**
 * Interface UserContract
 * @package App\Repositories\Workshop
 */
interface WorkshopContract {

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
    public function getWorkshopsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_WorkshopController_description = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshops($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param $id
     * @param $input
     * @param $coordinators
     * @return mixed
     */
    public function update($id, $input, $coordinators);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    public function isCoordinator($order_by = 'workshops.id', $sort = 'asc');
    public function getAllActivitiesAndTutors($order_by = 'workshops.id', $sort = 'asc');


}