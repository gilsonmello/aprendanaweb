<?php namespace App\Repositories\Backend\Module;

/**
 * Interface UserContract
 * @package App\Repositories\Module
 */
interface ModuleContract {

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
    public function getModulesPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllModules($order_by = 'id', $sort = 'asc');

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

    public function selectModules($term = '', $order_by = 'name', $sort = 'asc');

    public function getAllModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc');

    public function getPresentialModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc');

    public function getComplementaryModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc');

    public function getOnlineModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc');

    public function getLessonsPerTeacherPerModule($module_id);
}