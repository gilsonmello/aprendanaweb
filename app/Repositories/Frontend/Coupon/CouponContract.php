<?php namespace App\Repositories\Frontend\Coupon;

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

}