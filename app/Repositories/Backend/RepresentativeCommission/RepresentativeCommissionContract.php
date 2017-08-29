<?php

namespace App\Repositories\Backend\RepresentativeCommission;

/**
 * Interface UserContract
 * @package App\Repositories\RepresentativeCommission
 */
interface RepresentativeCommissionContract {

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
    public function getRepresentativeCommissionsPaginated($per_page, $f_RepresentativeCommissionController_name = '', $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllRepresentativeCommissions($order_by = 'id', $sort = 'asc');

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
    public function update($id, $input, $students, $courses, $modules);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    public function getRepresentativeCommission($id);

    public function getRepresentativeCommissionsRepresentative($representative);

    public function createRepresentativeCommissionsRepresentative($representative);

}
