<?php namespace App\Services\CourseAlert\Traits;
/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:11
 */
use Carbon\Carbon;



trait CourseAlertAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.coursealerts.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.coursealerts.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';    
    }

    /**
     * @return string
     */
    public function getSendEmailButtonAttribute() {
        return '<a href="'.route('admin.coursealerts.sendemail', $this->id).'" data-method="put" data-alert="send_email" class="btn btn-xs btn-info"><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="' . trans('alerts.coursealerts.sendbyemail') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.$this->getSendEmailButtonAttribute();
    }
}
