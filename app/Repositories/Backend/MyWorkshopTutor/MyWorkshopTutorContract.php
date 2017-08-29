<?php namespace App\Repositories\Backend\MyWorkshopTutor;

/**
 * Interface UserContract
 * @package App\Repositories\MyWorkshopTutor
 */
interface MyWorkshopTutorContract {

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
    public function getMyWorkshopTutorsPaginated($per_page, $order_by = 'id', $sort = 'asc', $student = '', $has_tutor = '', $workshop = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllMyWorkshopTutors($order_by = 'id', $sort = 'asc');

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