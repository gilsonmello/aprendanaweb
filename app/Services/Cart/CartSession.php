<?php

namespace App\Services\Cart;

use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 1/12/16
 * Time: 1:38 PM
 */
trait CartSession {

    public $orderInSession;

    public function setDiscountInSession($discount) {
        session(['discount' => $discount]);
    }

    public function getDiscountInSession() {
        return session('discount') === null ? 0 : session('discount');
    }

    public function destroyDiscountInSession() {
        Session::forget('discount');
    }

    public function setCouponInSession($coupon) {
        session(['coupon' => $coupon]);
    }

    public function getCouponInSession() {
        return session('coupon');
    }

    public function destroyCouponInSession() {
        Session::forget('coupon');
    }

    public function setOrderIdInSession($order_id) {
        session(['order_id_in_session' => $order_id]);
        $this->orderInSession = $order_id;
    }

    public function getOrderIdInSession() {
        return session('order_id_in_session');
    }

    public function hasOrderInSession() {
        return session('order_id_in_session') ? true : false;
    }

    public function destroyOrderInSession() {
        Session::forget('order_id_in_session');
        $this->orderInSession = null;
    }

    public function setPartnerInSession($coupon) {
        session(['partner' => $coupon]);
    }

    public function getPartnerInSession() {
        return session('partner');
    }

    public function destroyPartnerInSession() {
        Session::forget('partner');
    }

    /**
     * Check if exists last cart in session
     *
     * @return bool
     */
    public function hasLastCartInSession() {
        return session('last_cart') ? true : false;
    }

    public function handleWithLastCart() {
        if ($this->hasLastCartInSession()) {
            Session::forget('last_cart');
            Session::forget('discount');
            Session::forget('order_id_in_session');
        }
    }

    public function createOrGetLastCart() {
        if (!$this->hasLastCartInSession()) {
            $items = $this->getFullCart();
            session(['last_cart' => $items]);
            $this->destroy();
        } else {
            $items = session('last_cart');
        }

        return $items;
    }

    /**
     * Update origin external if exists
     *
     * @param $order_id
     * @return bool
     */
    public function updateOriginExternal($order_id) {
        if (session('origin_external')) {
            $origin = session('origin_external');
            $origin->order_id = $order_id;
            $origin->save();
        }
    }

}
