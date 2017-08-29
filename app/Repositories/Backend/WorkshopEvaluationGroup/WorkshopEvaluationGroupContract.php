<?php namespace App\Repositories\Backend\WorkshopEvaluationGroup;

/**
 * Interface UserContract
 * @package App\Repositories\WorkshopEvaluationGroup
 */
interface WorkshopEvaluationGroupContract {

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
    public function getWorkshopEvaluationGroupsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_WorkshopEvaluationGroupController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopEvaluationGroups($order_by = 'id', $sort = 'asc');

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
     * @return mixed
     */
    public function destroy($id);


}