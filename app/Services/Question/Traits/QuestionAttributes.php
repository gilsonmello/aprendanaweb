<?php namespace App\Services\Question\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait QuestionAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.questions.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>' . ' ' .
            '<a href="'.route('admin.questions.edit', $this->id).'?f_QuestionController_edit_as_text=1" class="btn btn-xs btn-primary"><i class="fa fa-align-left" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button_as_text') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.questions.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    public function getAddButtonAttribute() {
        return '<a href="'.route('admin.groupquestions.add', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="' . trans('crud.add_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute();
    }

}