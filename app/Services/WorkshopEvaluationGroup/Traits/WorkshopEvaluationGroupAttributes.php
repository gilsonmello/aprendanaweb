<?php namespace App\Services\WorkshopEvaluationGroup\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait WorkshopEvaluationGroupAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.workshopevaluationgroups.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.workshopevaluationgroups.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getTutorsButtonAttribute() {
        return '<a href="'.route('admin.workshopgrouptutors.index')."?f_evaluationgroup_id=". $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-group" data-toggle="tooltip" data-placement="top" title="' . trans('strings.tutors') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.
        $this->getTutorsButtonAttribute();
    }
}