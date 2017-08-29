<?php namespace App\Repositories\Backend\AnalysisExam;

/**
 * Interface UserContract
 * @package App\Repositories\AnalysisExam
 */
interface AnalysisExamContract {

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
    public function getAnalysisExamsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisExamController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnalysisExams($order_by = 'id', $sort = 'asc');

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