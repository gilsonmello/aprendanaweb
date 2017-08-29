<?php namespace App\Services\Coupon\Traits;
/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:11
 */
use Carbon\Carbon;



trait CouponAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.coupons.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.coupons.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    public function getSendEmailButtonAttribute(){
        return '<a href="'.route('admin.coupons.send', $this->id).'"  class="btn btn-xs btn-info"><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="' . trans('crud.send_button') . '"></i></a>';

    }

    public function getStartDateAttribute($start_date) {
        return Carbon::parse($start_date)->format('d/m/Y');
    }

    public function getDueDateAttribute($due_date) {
        return Carbon::parse($due_date)->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.
        $this->getSendEmailButtonAttribute()
        ;
    }
}
