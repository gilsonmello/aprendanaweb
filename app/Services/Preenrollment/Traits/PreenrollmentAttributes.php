<?php namespace App\Services\Preenrollment\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait PreenrollmentAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return ''; //'<a href="'.route('admin.preenrollments.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if ($this->date_activation == null) {
            return '<a href="' . route('admin.preenrollments.destroy', $this->id) . '" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getTimeButtonAttribute() {
        if ($this->date_activation == null) {
            return '<a href="'.route('admin.preenrollments.addday', [$this->id]).'" class="btn btn-xs btn-success"><i class="fa fa-days" data-toggle="tooltip" data-placement="top" title="' . trans('crud.preenrollments.addday_enrollment_button') . '"><b>+d</b></i></a> '
            .' '.
            '<a href="'.route('admin.preenrollments.addweek', [$this->id]).'" class="btn btn-xs btn-success"><i class="fa fa-days" data-toggle="tooltip" data-placement="top" title="' . trans('crud.preenrollments.addweek_enrollment_button') . '"><b>+s</b></i></a> ';
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getEmailButtonAttribute() {
        if ($this->date_activation == null) {
            return '<a href="'.route('admin.preenrollments.email', [$this->id]).'" class="btn btn-xs btn-success"><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="' . trans('crud.preenrollments.email_enrollment_button') . '"></i></a> ';
        } else {
            return '';
        }
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute()  . ' ' .
        $this->getTimeButtonAttribute() . ' ' .
        $this->getEmailButtonAttribute();
    }
}