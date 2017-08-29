<?php namespace App\Services\Partner\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait PartnerAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.partners.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.partners.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getStudentGroupButtonAttribute() {
        return '<a href="'. route('admin.studentgroups.index') . '?f_partner_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-tv" data-toggle="tooltip" data-placement="top" title="' . trans('crud.partner.studentgroups_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getPartnerManagerButtonAttribute() {
        return '<a href="'. route('admin.partnermanagers.create').'?f_partner_id= '.$this->id.'"  class="btn btn-xs btn-primary"><i class="fa fa-user-plus" data-toggle="tooltip" data-placement="top" title="' . trans('crud.partner_managers.create') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.
        $this->getPartnerManagerButtonAttribute();
    }
}