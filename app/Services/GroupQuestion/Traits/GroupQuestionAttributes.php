<?php namespace App\Services\GroupQuestion\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait GroupQuestionAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        if (($this->question_id != null) && ($this->question_id != '')){
            return '<a href="'.route('admin.groupquestions.edit', $this->question_id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>' . ' ' .
                   '<a href="'.route('admin.groupquestions.edit', $this->question_id).'?f_QuestionController_edit_as_text=1" class="btn btn-xs btn-primary"><i class="fa fa-align-left" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button_as_text') . '"></i></a>';
        }
    }

    /**
     * @return string
     */
    public function getChangeSequenceButtonAttribute() {
        return '<a href="javascript:modalGroupQuestionChangeSequence(' . $this->id. ')" class="btn btn-xs btn-primary "><i class="fa fa-arrows-alt" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.move_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.groupquestions.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getChangeSequenceButtonAttribute().' '.
        $this->getDeleteButtonAttribute();
    }
}