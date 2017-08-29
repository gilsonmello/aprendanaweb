<?php

namespace App\Services\Cart;

use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 04/05/16
 * Time: 15:42
 */
trait CartCoupon {

    public $couponInSession;

    /**
     * Check that coupon falls into one set of rules for use
     *
     * @param $code
     * @return mixed
     */
    public function couponIsAvailableToUse($code) {

        $cart = $this->getFullCart();

        $coupon = $this->coupon->findByCode($code);

        if (!$coupon)
            return ['available' => false, 'message' => 'O cupom não foi encontrado em nosso sistema.'];

        // Check use by date
        if (parsebr($coupon->due_date)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
            return ['available' => false, 'message' => 'O Cupom informado está vencido. Utilize outro cupom.'];

        if (parsebr($coupon->start_date)->format('Y-m-d') > Carbon::now()->format('Y-m-d'))
            return ['available' => false, 'message' => 'Cupom inválido. Utilize outro cupom.'];

        // Check use by limit
        if ($coupon->used == $coupon->limit)
            return ['available' => false, 'message' => 'A utilização deste cupom está esgotada.'];

        // Check if coupon is restrict to users
        if (count($coupon->users) >= 1) {

            if (auth()->check() == false)
                return ['available' => false, 'message' => 'A utilização deste cupom limita-se a usuários autenticados.'];
            if (!in_array(auth()->user()->id, $coupon->users->lists('id')->toArray()))
                return ['available' => false, 'message' => 'Você não está autorizado a utilizar este cupom.'];
        }

        // Check if coupon is restrict to courses
        if (count($coupon->courses) >= 1) {
            $idsCartCourses = [];
            foreach ($cart as $item) {
                $idsCartCourses[] = $item->id;
            }

            $idsCouponCourses = $coupon->courses->lists('id')->toArray();

            $isThereCourse = array_intersect($idsCouponCourses, $idsCartCourses);

            if (count($isThereCourse) == 0)
                return ['available' => false, 'message' => 'A utilização deste cupom limita-se a cursos especificos.'];
        }

        $this->setCouponInSession($coupon);
        $this->calculateDiscountFromCoupon($coupon);

        return ['available' => true, 'message' => 'Cupom disponível para utilização.'];
    }

    /**
     * Calculate discount from a validated coupon
     *
     * @param $coupon
     */
    public function calculateDiscountFromCoupon($coupon) {
        $cart = $this->getFullCart();

        // Checks whether coupon is a percentage
        if ((float) $coupon->percentage > 0) {
            $discount = 0;

            if (count($coupon->courses) > 0) { //Se existe curso especificado no cupom
                foreach ($cart as $item) {
                    if (in_array($item->id, $coupon->courses->lists('id')->toArray())) {

                        $checkDiscount = ($coupon->percentage / 100) * $item->options->original_price;

                        //Se o desconto for mario que o preço de venda o valor do desconto deve ser zero = 0
                        if ($checkDiscount > $item->price) {
                            $discount += $item->price;
                        } else {
                            $discount += ($coupon->percentage / 100) * $item->options->original_price;
                        }

                        $checkDiscount = 0;
                    }
                }
            } else {

                $total = 0;
                foreach ($cart as $item) {
                    $checkDiscount = ($coupon->percentage / 100) * $item->options->original_price;

                    //Se o desconto for mario que o preço de venda o valor do desconto deve ser zero = 0
                    if ($checkDiscount > $item->price) {
                        $discount += $item->price;
                    } else {
                        $discount += ($coupon->percentage / 100) * $item->options->original_price;
                    }

                    $checkDiscount = 0;
                    $total += $discount;
                }

//                $discount = $total;
            }
        }


        // Checks whether coupon is a value
        if ((float) $coupon->value > 0) {
            $discount = 0;

            if (count($coupon->courses) >= 1) {
                foreach ($cart as $item) {
                    if (in_array($item->id, $coupon->courses->lists('id')->toArray())) {
                        $discount = $discount + $coupon->value;
                    }
                }
            } else {
                $discount = $coupon->value;
            }
        }

        $coupon->save();

        if (isset($discount))
            $this->setDiscountInSession($discount);
    }

    /**
     * Apply discounts in order course items
     *
     * @param $coupon_code
     */
    public function applyDiscountsCourseItems($coupon_code) {
        $order = $this->order->updateTotalById($this->orderInSession, $this->get('total'));
        $i = 0;
        $a = array();
        $coupon = $this->coupon->findByCode($coupon_code);

        foreach ($order->courses as $orderCourse) {

            if (count($coupon->courses) >= 1 && !in_array($orderCourse->course_id, $coupon->courses->lists('id')->toArray())) {
                continue;
            }

            if ($orderCourse->original_price == $orderCourse->price) {  //Caso os valores seja iguais
                $discount = ($coupon->percentage / 100) * $orderCourse->price;
                $orderCourse->discount_price = $orderCourse->price - $discount;
            } else {

                $checkDiscount = ($coupon->percentage / 100) * $orderCourse->original_price;

                if ($checkDiscount > $orderCourse->price) { //Caso o desconto seja maior que o valor do produto no site
                    $discount = $orderCourse->price; //O valor do desconto será o valor do produto, ou seja, 100%
                    $orderCourse->discount_price = $orderCourse->price - $discount;
                } else {

                    $discount = ($coupon->percentage / 100) * $orderCourse->original_price;
                    $perc_valid = (($orderCourse->original_price - $discount) / $orderCourse->price); //Percentual Válido para desconto

                    if ($perc_valid > 0) { // Verifica se o Percentual e maior que zero
                        if ($perc_valid > 1) {
                            $perc_valid = $perc_valid - 1;
                            $perc_valid = number_format($perc_valid, 2);
                        } else {
                            $perc_valid -= 1;
                            $perc_valid = $perc_valid * -1; //Convertendo o valor para positivo
                            $perc_valid = number_format($perc_valid, 2);
                        }
                    }

                    $discount = $perc_valid * $orderCourse->price;
                    $orderCourse->discount_price = $orderCourse->price - $discount;
                }
            }

            $orderCourse->save();
            $a[$i] = $discount;
            $this->updateById($orderCourse->course_id, 'course', ['discount_price' => $orderCourse->discount_price]);
            $i++;
        }

        $totalDiscount = 0;
        for ($i = 0; $i < count($a); $i++) {
            $totalDiscount += $a[$i];
        }

        return $totalDiscount;
    }

    /**
     * Apply discounts in order package items
     *
     * @param $coupon_code
     */
    public function applyDiscountsPackageItems($coupon_code) {
        $order = $this->order->updateTotalById($this->orderInSession, $this->get('total'));
        $i = 0;
        $a = array(); //
        $coupon = $this->coupon->findByCode($coupon_code);

        foreach ($order->packages as $orderPackage) {

            if (count($coupon->package) >= 1 && !in_array($orderPackage->package_id, $coupon->package->lists('id')->toArray())) {
                continue;
            }

            if ($orderPackage->original_price == $orderPackage->price) {  //Caso os valores seja iguais
                $discount = ($coupon->percentage / 100) * $orderPackage->price;
                $orderPackage->discount_price = $orderPackage->price - $discount;
            } else {

                $checkDiscount = ($coupon->percentage / 100) * $orderPackage->original_price;

                if ($checkDiscount > $orderPackage->price) { //Caso o desconto seja maior que o valor do produto no site
                    $discount = $orderPackage->price; //O valor do desconto será o valor do produto, ou seja, 100%
                    $orderPackage->discount_price = $orderPackage->price - $discount;
                } else {

                    $discount = ($coupon->percentage / 100) * $orderPackage->original_price;

                    $perc_valid = (($orderPackage->original_price - $discount) / $orderPackage->price); //Percentual Válido para desconto

                    if ($perc_valid > 0) { // Verifica se o Percentual e maior que zero
                        if ($perc_valid > 1) {
                            $perc_valid = $perc_valid - 1;
                            $perc_valid = number_format($perc_valid, 2);
                        } else {
                            $perc_valid -= 1;
                            $perc_valid = $perc_valid * -1; //Convertendo o valor para positivo
                            $perc_valid = number_format($perc_valid, 2);
                        }
                    }

                    $discount = $perc_valid * $orderPackage->price;
                    $orderPackage->discount_price = $orderPackage->price - $discount;
                }
            }

            $orderPackage->save();
            $a[$i] = $discount;
            $this->updateById($orderPackage->package_id, 'package', ['discount_price' => $orderPackage->discount_price]);
            $i++;
        }

        $totalDiscount = 0;
        for ($i = 0; $i < count($a); $i++) {
            $totalDiscount += $a[$i];
        }

        return $totalDiscount;
    }

    public function markCouponAsUsed() {
        $coupon = $this->getCouponInSession();

        if (count($coupon) > 0) {
            $coupon->used += 1;
            $coupon->save();
        }
    }

    /**
     * Destroy discount
     */
    public function destroyDiscount() {

        if ($this->getCouponInSession()) {
            $coupon = $this->getCouponInSession();

            if ($coupon->used <= 0) {
                $coupon->used = 0;
            } else {
                $coupon->used = $coupon->used - 1;
            }

            $coupon->save();
        }

        $this->destroyDiscountInSession();
        $this->destroyCouponInSession();
        $this->destroyPartnerInSession();
        $this->removeDiscountsOrderItems();
    }

    /**
     * Remove discounts in order items
     */
    public function removeDiscountsOrderItems() {
        $order = $this->order->findOrThrowException($this->orderInSession);
        $order->coupon_id = null;
        $order->partner_id = null;
        $order->discount_price = $order->price;
        $order->save();

        foreach ($order->courses as $orderCourse) {
            $orderCourse->discount_price = $orderCourse->price;
            $orderCourse->save();
        }

        foreach ($order->packages as $orderPackage) {
            $orderPackage->discount_price = $orderPackage->price;
            $orderPackage->save();
        }
    }

}
