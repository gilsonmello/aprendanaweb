<?php namespace App\Repositories\Backend\Video;

/**
 * Interface UserContract
 * @package App\Repositories\Video
 */
interface VideoContract {

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
    public function getVideosPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_VideoController_title = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllVideos($order_by = 'id', $sort = 'asc');

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
    public function update($id, $input, $teachers);

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