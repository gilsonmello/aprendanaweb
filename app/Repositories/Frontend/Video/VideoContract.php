<?php namespace App\Repositories\Frontend\Video;

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
    public function getVideosPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllVideos($order_by = 'id', $sort = 'asc');

}