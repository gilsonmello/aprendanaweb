<?php namespace App\Repositories\Frontend\Coupon;

use App\Coupon;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentCouponRepository
 * @package App\Repositories\Coupon
 */
class EloquentCouponRepository implements CouponContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$coupon = Coupon::withTrashed()->find($id);

		if (! is_null($coupon)) return $coupon;

		throw new GeneralException('That coupon does not exist.');
	}

    /**
     * @param $code
     * @return mixed
     * @throws GeneralException
     */
    public function findByCode($code) {
        $coupon = $coupon = Coupon::where('code', $code)->first();

        if (! is_null($coupon)) return $coupon;

        throw new GeneralException('Cupom inexistente.');
    }

}