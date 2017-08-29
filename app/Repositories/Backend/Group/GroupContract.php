<?php namespace App\Repositories\Backend\Group;

/**
 * Interface UserContract
 * @package App\Repositories\Group
 */
interface GroupContract {

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
    public function getGroupsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_exam_edit = 0);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllGroups($order_by = 'id', $sort = 'asc', $f_exam_edit = 0);

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_exam_edit);

    public function createForLesson($lesson);

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


     public function createSubjectRelations($input);

    public function createCourseSubjectRelations($input);

}