<?php namespace App\Repositories\Backend\Studentgroup;

/**
 * Interface UserContract
 * @package App\Repositories\Studentgroup
 */
interface StudentgroupContract {

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
    public function getStudentgroupsPaginated($per_page, $partner_id, $order_by = 'id', $sort = 'asc', $f_StudentgroupController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllStudentgroups($order_by = 'id', $sort = 'asc');

    public function getStundentGroupByPartnerAndName($partner_id, $name);

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