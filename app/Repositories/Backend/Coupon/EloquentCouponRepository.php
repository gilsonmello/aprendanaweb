<?php

namespace App\Repositories\Backend\Coupon;

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

        if (!is_null($coupon))
            return $coupon;

        throw new GeneralException('That coupon does not exist.');
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function getCoupon($id) {
        return Coupon::withTrashed()->find($id);
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getCouponsPaginated($per_page, $f_CouponController_name = '', $order_by = 'id', $sort = 'asc', $includePartner = false) {
        $query = Coupon::where('name', 'like', '%' . $f_CouponController_name . '%')
                ->orWhere('code', 'like', '%' . $f_CouponController_name . '%');
        if ($includePartner === false) {
            $query->whereNull('partner_id');
            $query->whereNull('advertisingpartner_id');
        }
        return $query->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedCouponsPaginated($per_page) {
        return Coupon::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCoupons($order_by = 'id', $sort = 'asc') {
        return Coupon::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $coupon = $this->createCouponStub($input);
        if ($coupon->save()) {
            $coupon->users()->attach($input['students']);
            $coupon->courses()->attach($input['courses']);
            $coupon->modules()->attach($input['modules']);
            return true;
        }
        throw new GeneralException('There was a problem creating this coupon. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $students, $courses, $modules) {
        $coupon = $this->findOrThrowException($id);

        if ($coupon->update($input)) {
            $coupon->name = $input['name'];
            $coupon->code = $input['code'];
            $coupon->start_date = parsebr($input['start_date']);
            $coupon->due_date = parsebr($input['due_date']);
//            $coupon->limit = $input['limit'];
//            $coupon->percentage = parsemoneybr($input['percentage']);
//            $coupon->value = parsemoneybr($input['value']);

            if (isset($students['students']))
                $coupon->users()->sync($students['students']);
            else
                $coupon->users()->sync([]);

            if (isset($courses['courses']))
                $coupon->courses()->sync($courses['courses']);
            else
                $coupon->courses()->sync([]);

            if (isset($modules['modules']))
                $coupon->modules()->sync($modules['modules']);
            else
                $coupon->modules()->sync([]);

            $coupon->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this coupon. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $coupon = $this->findOrThrowException($id);
        if ($coupon->delete())
            return true;

        throw new GeneralException("There was a problem deleting this coupon. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createCouponStub($input) {

        $coupon = new Coupon;
        $coupon->name = $input['name'];
        $coupon->code = $input['code'];
        $coupon->start_date = parsebr($input['start_date']);
        $coupon->due_date = parsebr($input['due_date']);
        $coupon->limit = $input['limit'];
        $coupon->used = 0;
        $coupon->percentage = $input['percentage'];
        $coupon->value = $input['value'];
        $coupon->user_id_created_by = auth()->user()->id;
        $coupon->description = $input['description'];
        return $coupon;
    }

    public function importFromPartner($fileKeyPath, $partner, $percentage, $value, $daysToUse, $limit) {

        $start_date = Carbon::now();
        $end_date = Carbon::now()->addDay($daysToUse);

        $file = fopen($fileKeyPath, 'r');
        while (($line = fgetcsv($file, 0, ";")) !== false) {
            $coupon = Coupon::firstOrNew(['code' => $line[0]], ['partner_id' => $partner], ['deleted_at' => null]);
            $coupon->name = trans('strings.partner') . ' ' . $partner;
            $coupon->code = $line[0];
            $coupon->start_date = $start_date;
            $coupon->due_date = $end_date;
            $coupon->limit = $limit;
            $coupon->used = 0;
            $coupon->percentage = $percentage;
            $coupon->value = $value;
            $coupon->partner_id = $partner;
            $coupon->user_id_created_by = auth()->user()->id;
            if ($coupon->trashed()) {
                $coupon->restore();
            }
            $coupon->save();
        }
        fclose($file);

        //delete records not in the file
        Coupon::where('partner_id', '=', $partner)->where('start_date', '!=', $start_date)->update(['deleted_at' => Carbon::now()]);
    }

    public function getCouponsRepresentative($representative){
        return Coupon::where('user_id_representative', '=', $representative)->orderBy("id", "desc")->get();
    }

    public function createCouponsRepresentative($userrepresentative){
        $coupon = new Coupon;
        $timestp = Carbon::now()->timestamp;
        $coupon->name = $userrepresentative->name . ' - ' . $timestp;
        $coupon->code = $userrepresentative->id . '-' .$timestp;
        $coupon->start_date = Carbon::now();
        $coupon->due_date = Carbon::now()->addYear(2);
        $coupon->limit = 9999;
        $coupon->used = 0;
        $coupon->percentage = 5;
        $coupon->value = 0;
        $coupon->user_id_created_by = auth()->user()->id;
        $coupon->user_id_representative = $userrepresentative->id;
        $coupon->description = $userrepresentative . ' - ' . $timestp;

        $coupon->save();

        return $coupon;

    }
}
