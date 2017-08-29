<?php namespace App\Services\WorkshopActivity\Traits;
use Carbon\Carbon;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait WorkshopActivityAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.workshopactivitys.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.workshopactivitys.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute();
    }

    public function getAvailableDateAttribute($available_date) {
        if ($available_date == null)
            return '';
        else
            return Carbon::parse($available_date)->format('d/m/Y');
    }

    public function getSubmitDeadlineDateAttribute($submit_deadline_date) {
        if ($submit_deadline_date == null)
            return '';
        else
            return Carbon::parse($submit_deadline_date)->format('d/m/Y');
    }

    public function getEvaluationDeadlineDateAttribute($evaluation_deadline_date) {
        if ($evaluation_deadline_date == null)
            return '';
        else
            return Carbon::parse($evaluation_deadline_date)->format('d/m/Y');
    }

}