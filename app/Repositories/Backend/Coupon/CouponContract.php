<?php

namespace App\Repositories\Backend\Coupon;

/**
 * Interface UserContract
 * @package App\Repositories\Coupon
 */
interface CouponContract {

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
    public function getCouponsPaginated($per_page, $f_CouponController_name = '', $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCoupons($order_by = 'id', $sort = 'asc');

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

    public function importFromPartner($fileKeyPath, $partner, $percentage, $value, $daysToUse, $limit);

    public function getCoupon($id);

    public function getCouponsRepresentative($representative);

    public function createCouponsRepresentative($representative);

}
