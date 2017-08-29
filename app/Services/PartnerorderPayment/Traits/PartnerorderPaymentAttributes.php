<?php namespace App\Services\PartnerorderPayment\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait PartnerorderPaymentAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        if ($this->processed == 1){
            return '';
        } else {
            return '<a href="'.route('admin.partnerorderpayments.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
        }
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if ($this->processed == 1){
            return '';
        } else {
            return '<a href="'.route('admin.partnerorderpayments.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        }
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute();
    }
}