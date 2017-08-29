<?php

namespace App\Repositories\Frontend\News;

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
    public function getNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $except, $tag);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllNews($order_by = 'id', $sort = 'asc');

    public function getFeaturedNews($order_by = 'id', $sort = 'asc');

    public function getLastNews();
}
