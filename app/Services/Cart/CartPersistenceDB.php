<?php

namespace App\Services\Cart;

use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 1/12/16
 * Time: 1:54 PM
 */
trait CartPersistenceDB {

    /**
     * @param $item
     */
    public function deleteOrderItem($item) {

        $order = $this->order->findOrThrowException($this->orderInSession);

        // If cart is empty, destroy everything. Order and items order
        if (Cart::count() == 0) {
            if ($order) {
                if ($item->options->type == 'course')
                    $this->orderCourse->destroyByOrder($this->orderInSession);
                if ($item->options->type == 'package')
                    $this->orderPackage->destroyByOrder($this->orderInSession);
                $this->order->destroy($this->orderInSession);
            }

            $this->destroyOrderInSession();

            // Else, destroy only $item
        }else {
            if ($item->options->type == 'course')
                $this->orderCourse->destroyByOrderAndCourse($this->orderInSession, $item->id);
            if ($item->options->type == 'package')
                $this->orderPackage->destroyByOrderAndPackage($this->orderInSession, $item->id);
        }
    }

    /**
     * Create order in the initial state and if there is already updated total cart
     * @author 
     * @param $item
     * @param $type
     * @date 15/02/2017
     */
    public function createOrUpdateOrder($item, $type) {

        if ($this->hasOrderInSession()) {
            //dd($this->orderInSession, $this->get('total'));
            $order = $this->order->updateTotalById($this->orderInSession, $this->get('total'));
        } else {
            $order = $this->order->storeByCartAdd($this->get('total'));
            $this->setOrderIdInSession($order->id);
        }
        
        if ($type == 'course')
            $this->orderCourse->createByCartAdd($order, $item);
        if ($type == 'package')
            $this->orderPackage->createByCartAdd($order, $item);

        $this->updateOriginExternal($order->id);
    }

    /**
     * Assign student to order
     *
     * @param $order_id
     * @param $student_id
     */
    public function assignStudent($order_id, $student_id) {
        $this->order->updateStudentById($order_id, $student_id);
    }

}
