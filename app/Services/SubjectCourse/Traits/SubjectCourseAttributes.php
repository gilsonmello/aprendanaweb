<?php namespace App\Services\SubjectCourse\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait SubjectCourseAttributes {

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.subjectcourses.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getDeleteButtonAttribute();
    }
}