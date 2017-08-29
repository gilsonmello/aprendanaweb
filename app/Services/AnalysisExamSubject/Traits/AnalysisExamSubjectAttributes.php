<?php namespace App\Services\AnalysisExamSubject\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait AnalysisExamSubjectAttributes {

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.analysisexamsubjects.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getDeleteButtonAttribute();
    }
}