<?php

namespace App\Services\Order\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait OrderAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="' . route('admin.orders.edit', $this->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if ($this->status_id <> 4) {
            return '<a href="' . route('admin.orders.destroy', $this->id) . '" data-method="delete" data-alert="delete-order" data-id="' . $this->id . '" data-message="Deseja excluir o pedido?" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        }
    }

    /**
     * @return string
     */
    public function getSendEmailButtonAttribute() {
        if ($this->status_id == 2 || $this->status_id == 1) {
            return '<a style="margin-top: 1px;" href="' . route('admin.orders.cart_recovery', $this->id) . '" data-alert="send_email" data-message="Deseja enviar cupom de desconto para o aluno?" data-method="put" class="btn btn-xs btn-info"><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="' . trans('crud.send_coupon') . '"></i></a>';
        }
        return '';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute() . ' ' .
                $this->getStatusButtonAttribute() . ' ' .
                $this->getSendEmailButtonAttribute() . ' ' .
                $this->getDeleteButtonAttribute();
    }

    /**
     * @return string
     */
    public function getStatusButtonAttribute() {
        if (($this->status_id == 1) || ($this->status_id == 2) || ($this->status_id == 3)) {
            return ''; //'<a href="' . route('admin.orders.activated', [$this->id]) . '" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_order_button') . '"></i></a> ';
        }
    }

    public function getUserModeratorNameAttribute() {
        if ($this->userModerator == null) {
            return "";
        } else {
            return $this->userModerator->name;
        }
    }

}
