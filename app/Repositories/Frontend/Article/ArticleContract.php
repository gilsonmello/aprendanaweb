<?php namespace App\Repositories\Frontend\Article;

/**
 * Interface UserContract
 * @package App\Repositories\Article
 */
interface ArticleContract {

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
    public function getArticlesPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllArticles($order_by = 'id', $sort = 'asc');

}