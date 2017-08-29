<?php namespace App\Repositories\Backend\News;

/**
 * Interface UserContract
 * @package App\Repositories\News
 */
interface NewsContract {

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
    public function getAllNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '');

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllNews($order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewsNotActive($order_by = 'id', $sort = 'asc');

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