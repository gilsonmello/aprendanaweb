<?php

namespace App\Services\Studentgroup\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait StudentgroupAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="' . route('admin.studentgroups.edit', $this->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="' . route('admin.studentgroups.destroy', $this->id) . '" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEmailButtonAttribute() {
        return '<a href="' . route('admin.preenrollments.sendemaillist', $this->id) . '" class="btn btn-xs btn-danger"><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="' . trans('crud.preenrollments.email_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute() . ' ' .
                $this->getDeleteButtonAttribute();
    }



}
