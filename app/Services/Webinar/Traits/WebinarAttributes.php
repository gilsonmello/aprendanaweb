<?php namespace App\Services\Webinar\Traits;
use Carbon\Carbon;
/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait WebinarAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.webinars.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.webinars.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }


    /**
     * @return string
     */
    public function getUsersButtonAttribute() {
        return '<a style="margin-top: 1px;" href="#" id="btn-webinars-users" data-id="'.$this->id.'" class="btn btn-xs btn-primary"><i class="fa fa-user" data-toggle="tooltip" data-placement="top" title="' . trans('crud.permissions.users') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.
        $this->getUsersButtonAttribute();
    }

    public function getAvailableDateAttribute($available_date) {
        if ($available_date == null)
            return '';
        else
            return Carbon::parse($available_date)->format('d/m/Y');
    }

}