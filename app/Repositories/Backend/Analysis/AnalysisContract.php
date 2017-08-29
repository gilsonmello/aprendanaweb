<?php namespace App\Repositories\Backend\Analysis;

/**
 * Interface UserContract
 * @package App\Repositories\Analysis
 */
interface AnalysisContract {

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
    public function getAnalysissPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnalysiss($order_by = 'id', $sort = 'asc');

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