<?php namespace App\Services\View\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait ViewAttributes {

    /**
     * @return string
     */
    public function getViewButtonAttribute() {

        return
            '<a href="'.route('admin.userstudents.addview', [$this->enrollment->student_id, $this->enrollment_id, $this->id ]).'" class="btn btn-xs btn-primary"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>'
            .' '.
            '<a href="'.route('admin.userstudents.subtractview', [$this->enrollment->student_id, $this->enrollment_id, $this->id ]).'" class="btn btn-xs btn-danger"><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>'
            .' '.
            '<a href="'.route('admin.userstudents.viewed', [$this->enrollment->student_id, $this->enrollment_id, $this->id ]).'" class="btn btn-xs btn-success"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="' . trans('crud.view_button') . '"></i></a>'
            . ' ' .
            '<a href="' . route('admin.userstudents.lessons-log', [$this->enrollment_id, $this->id]) . '" class="btn btn-xs btn-danger"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" data-placement="top" title="' . trans('crud.log_button') . '"></i></a>';
    }


}