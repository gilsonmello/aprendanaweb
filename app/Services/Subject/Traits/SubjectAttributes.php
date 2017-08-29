<?php namespace App\Services\Subject\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait SubjectAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.subjects.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.subjects.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getCourseButtonAttribute() {
        return '<a href="'. route('admin.subjectcourses.index') . '?f_subject_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-tv" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.courses_button') . '"></i></a>';
    }

    public function getPackageButtonAttribute(){
        return '<a href="'. route('admin.subjectpackages.index') . '?f_subject_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.packages_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.
        $this->getCourseButtonAttribute() . ( $this->parent == null ? ' ' . $this->getPackageButtonAttribute() : "" );
    }
}