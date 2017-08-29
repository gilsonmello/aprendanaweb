<?php namespace App\Repositories\Frontend\ContentComments;

/**
 * Interface UserContract
 * @package App\Repositories\FaqCategory
 */
interface ContentCommentsContract {

    public function findOrThrowException($id);



    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    public function getCommentsOnLesson($lesson, $order_by = 'created_at', $sort = 'desc');

    public function getCommentsOnContent($content, $order_by = "created_at", $sort = 'desc');

    public function createComment($content,$comment,$publisher);

}