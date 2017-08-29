<?php namespace App\Repositories\Backend\Configuration;

/**
 * Interface UserContract
 * @package App\Repositories\configs
 */
interface ConfigurationContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id = 1);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getConfigurationsPaginated($per_page, $order_by = 'name', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllConfigurations($order_by = 'name', $sort = 'asc');

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
    public function update($input);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

}