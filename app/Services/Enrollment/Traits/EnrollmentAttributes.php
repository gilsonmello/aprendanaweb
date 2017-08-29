<?php

namespace App\Services\Enrollment\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait EnrollmentAttributes {
    
     /**
     * @return string
     */
    public function getReleaseForCertificationButtonAttribute() {
        return '<a href="' . route('admin.enrollments.updatereleaseforcertification', $this->id) . '"data-alert="released_for_certification" data-message="Deseja ceriticar esta matrícula?" data-method="POST" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="' . route('admin.enrollments.edit', $this->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="' . route('admin.enrollments.destroy', $this->id) . '" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute() . ' ' .
                $this->getDeleteButtonAttribute();
    }

    public function getStatusButtonAttribute() {
        if ($this->is_active == null) {
            return '<a href="' . route('admin.userstudents.enrollment.activated', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.enrollments.activate_enrollment_button') . '"></i></a> ';
        } else {
            return '<a href="' . route('admin.userstudents.enrollment.deactivated', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.enrollments.deactivate_enrollment_button') . '"></i></a> ';
        }
    }

    /**
     * @return string
     */
    public function getTimeButtonAttribute() {
        return '<a href="' . route('admin.userstudents.enrollment.addday', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-success"><i class="fa fa-days" data-toggle="tooltip" data-placement="top" title="' . trans('crud.enrollments.addday_enrollment_button') . '"><b>+d</b></i></a> '
                . ' ' .
                '<a href="' . route('admin.userstudents.enrollment.addweek', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-success"><i class="fa fa-days" data-toggle="tooltip" data-placement="top" title="' . trans('crud.enrollments.addweek_enrollment_button') . '"><b>+s</b></i></a> '
                . ' ' .
                '<a href="' . route('admin.userstudents.enrollment.addmonth', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-success"><i class="fa fa-days" data-toggle="tooltip" data-placement="top" title="' . trans('crud.enrollments.addmonth_enrollment_button') . '"><b>+m</b></i></a> ';
    }

    /**
     * @return string
     */
    public function getLessonsButtonAttribute() {
        return
                '<a href="' . route('admin.userstudents.lessons', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>'
                . ' ' .
                $this->getStatusButtonAttribute()
                . ' ' .
                $this->getTimeButtonAttribute()
                . ' ' .
                '<a href="' . route('admin.userstudents.log', [$this->student_id, $this->course_id]) . '" class="btn btn-xs btn-danger"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" data-placement="top" title="' . trans('crud.log_button') . '"></i></a>';
    }

    public function getExecutionButtonAttribute() {
        return
                '<a href="' . route('admin.userstudents.addexecution', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-primary"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>'
                . ' ' .
                '<a href="' . route('admin.userstudents.subtractexecution', [$this->student_id, $this->id]) . '" class="btn btn-xs btn-danger"><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getExamButtonAttribute() {
        return
                $this->getExecutionButtonAttribute()
                . ' ' .
                $this->getStatusButtonAttribute()
                . ' ' .
                $this->getTimeButtonAttribute();
    }

}
