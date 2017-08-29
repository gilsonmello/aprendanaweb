<?php namespace App\Repositories\Backend\CourseContent;


interface CourseContentContract {

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
    public function getContentPaginated($per_page, $order_by = 'id', $sort = 'asc');


    public function findByCourse($course_id);

    public function findByCourseAndSequence($course_id,$sequence);

    public function update($now_content, $url);



    public function create($course,$url,$sequence);

    public function saveFile($course,$name,$destinationPath);

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