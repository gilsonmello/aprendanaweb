<?php namespace App\Repositories\Backend\PartnerorderPayment;

/**
 * Interface UserContract
 * @package App\Repositories\PartnerorderPayment
 */
interface PartnerorderPaymentContract {

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
    public function getPartnerorderPaymentsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_exam_edit = 0);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPartnerorderPayments($order_by = 'id', $sort = 'asc', $f_exam_edit = 0);

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $f_exam_edit);


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

    public function getPartnerOrdersForPayment($datebegin, $dateend = null);

}