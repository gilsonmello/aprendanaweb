<?php namespace App\Repositories\Backend\Content;

/**
 * Interface UserContract
 * @package App\Repositories\FaqCategory
 */
interface ContentContract {

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
    public function getContentPaginated($per_page,$status, $order_by = 'id', $sort = 'asc');


    public function findByLesson($lesson_id);

    public function findByLessonAndSequence($lesson_id,$sequence);

    public function update($now_content, $url);



    public function create($lesson,$url,$sequence);

    public function saveFile($lesson,$name,$destinationPath);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllContent($order_by = 'id', $sort = 'asc');


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

}