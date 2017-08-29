<?php namespace App\Repositories\Backend\MyWorkshopEvaluation;

/**
 * Interface UserContract
 * @package App\Repositories\MyWorkshopEvaluation
 */
interface MyWorkshopEvaluationContract {

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
    public function getMyWorkshopEvaluationsPaginated($per_page = NULL, $f_evaluation_deadline_begin, $f_evaluation_deadline_end, $f_evaluation_status, $f_evaluation_workshop_id, $f_evaluation_student_name, $f_MyWorkshopEvaluationController_question, $order_by, $f_MyWorkshopEvaluationController_export_to_csv, $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllMyWorkshopEvaluations($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $workshop_id);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function updateTutor($id, $input);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);


}