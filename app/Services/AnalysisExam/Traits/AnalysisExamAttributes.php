<?php namespace App\Services\AnalysisExam\Traits;
use Carbon\Carbon;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait AnalysisExamAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.analysisexams.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.analysisexams.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    public function getSubjectButtonAttribute() {
        return '<a href="'. route('admin.analysisexamsubjects.index') . '?f_analysisexam_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-tv" data-toggle="tooltip" data-placement="top" title="' . trans('crud.analysisexam.subject_button') . '"></i></a>';
    }

    /**
     * @param $activation_date
     * @return mixed
     */
    public function getDateAttribute($date) {
        if ($date == null) return "";
        return Carbon::parse($date)->format('d/m/Y');
    }


    /**
     * @param $activation_date
     * @return mixed
     */
    public function getDateResultAttribute($date_result) {
        if ($date_result == null) return "";
        return Carbon::parse($date_result)->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.
        $this->getSubjectButtonAttribute();
    }
}