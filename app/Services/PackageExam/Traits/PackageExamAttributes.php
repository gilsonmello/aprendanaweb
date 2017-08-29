<?php namespace App\Services\PackageExam\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait PackageExamAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="javascript:modalPackageExamChangeSequence(' . $this->id. ')" class="btn btn-xs btn-primary "><i class="fa fa-arrows-alt" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.move_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.packageexams.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getDeleteButtonAttribute();
    }
}