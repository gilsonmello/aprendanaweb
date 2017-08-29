<?php namespace App\Repositories\Backend\ContentsComments;

/**
 * Interface UserContract
 * @package App\Repositories\FaqCategory
 */
interface ContentsCommentsContract {

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
    public function getContentsCommentsPaginated($per_page,$status, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllContentsComments($order_by = 'id', $sort = 'asc');


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

}