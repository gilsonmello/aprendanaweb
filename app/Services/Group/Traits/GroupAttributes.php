<?php namespace App\Services\Group\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait GroupAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.groups.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.groups.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    public function getQuestionsButtonAttribute(){
        return '<a href="'. route('admin.groupquestions.index') . '?f_group_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-list" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.questions_button') . '"></i></a>';
    }

    public function getConfQuestionsButtonAttribute(){
        return '<a href="'. route('admin.groupquestions.conf', $this->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.conf_questions_button') . '"></i></a>';
    }

    public function getThemesButtonAttribute(){
        return '<a href="'. route('admin.groupquestions.themes', $this->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-object-ungroup" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.themes_button') . '"></i></a>';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute(). ' ' .
        $this->getQuestionsButtonAttribute(). ' ' .
        $this->getConfQuestionsButtonAttribute(). ' ' .
        $this->getThemesButtonAttribute();
    }
}