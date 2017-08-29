<?php namespace App\Repositories\Backend\Subject;

/**
 * Interface UserContract
 * @package App\Repositories\Subject
 */
interface SubjectContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @param $name
     * @param $subject_id
     * @return mixed
     */
    public function getSubjectsPaginated($per_page, $order_by = 'id', $sort = 'asc', $name = '', $subject_id = NULL);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSubjects($order_by = 'id', $sort = 'asc');

    public function getSubjectsLastLevel($order_by = 'name', $sort = 'asc');

    public function getSubjectsLevel1and2($order_by = 'id', $sort = 'asc');

    public function getSubjectsLevel1($order_by = 'id', $sort = 'asc');



    public function getSubjectByLevel($level, $order_by = 'name', $sort = 'asc',$term = '');
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


}