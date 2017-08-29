<?php namespace App\Repositories\Backend\AnalysisExamGroup;

/**
 * Interface UserContract
 * @package App\Repositories\AnalysisExamGroup
 */
interface AnalysisExamGroupContract {

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
    public function getAnalysisExamGroupsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisExamGroupController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnalysisExamGroups($order_by = 'id', $sort = 'asc');

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