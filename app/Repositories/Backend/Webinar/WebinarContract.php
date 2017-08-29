<?php namespace App\Repositories\Backend\Webinar;

/**
 * Interface UserContract
 * @package App\Repositories\Banner
 */
interface WebinarContract {

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
    public function getWebinarsPaginated($per_page, $title, $order_by = 'id', $sort = 'asc') ;


    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input);

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input);

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id);


}