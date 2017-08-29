<?php namespace App\Services\MyWorkshopEvaluation\Traits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait MyWorkshopEvaluationAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {

//        if ((Carbon::today()->gt( parsebr($this->date_deadline ) )) && $this->grade <> null)
//            return '';
//        else
            return '<a href="'.route('admin.myworkshopevaluations.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditTutorActivityButtonAttribute() {

        if (isset($this->grade))
            return '';
        else
            return '<a id="btn-edit-tutor-activity" data-id="'.$this->id.'" class="btn btn-xs btn-primary"><i class="fa fa-user" data-toggle="tooltip" data-placement="top" title="' . trans('crud.myworkshopevaluations.edit_tutor_activity') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.myworkshopevaluations.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute(). ' '. $this->getEditTutorActivityButtonAttribute();
        //.' '. $this->getDeleteButtonAttribute();
    }

    public function getDateDeadlineAttribute($date_deadline) {
        if ($date_deadline == null)
            return '';
        else
            return Carbon::parse($date_deadline)->format('d/m/Y');
    }

    public function getDateEvaluationAttribute($date_evaluation) {
        if ($date_evaluation == null)
            return '';
        else
            return Carbon::parse($date_evaluation)->format('d/m/Y');
    }



}