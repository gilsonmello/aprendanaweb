<?php namespace App\Repositories\Backend\Partnerorder;

/**
 * Interface UserContract
 * @package App\Repositories\Partnerorder
 */
interface PartnerorderContract {

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
    public function getPartnerordersPaginated($per_page, $partner_id, $order_by = 'id', $sort = 'asc', $f_PartnerorderController_name = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPartnerorders($order_by = 'id', $sort = 'asc');

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