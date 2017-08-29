<?php namespace App\Repositories\Backend\AnalysisExamSubject;

/**
 * Interface UserContract
 * @package App\Repositories\AnalysisExamSubject
 */
interface AnalysisExamSubjectContract {

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
    public function getAnalysisExamSubjectsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisExamSubjectController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnalysisExamSubjects($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_analysisexam_edit);

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


    public function add($subject_id, $count, $analysisexam_id);

}