<?php

namespace App\Services\Cart;

use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 04/05/16
 * Time: 15:42
 */
trait CartPartner {

    /**
     * Check that coupon falls into one set of rules for use
     *
     * @param $code
     * @return mixed
     */
    public function discountPartner($partner_id, $key) {
        $cart = $this->getFullCart();

        $partner = $this->partner->findOrThrowException($partner_id);

        if (($key == null) || ($key == ''))
            return ['available' => false, 'message' => 'Informe o CPF.'];

        if (!$partner)
            return ['available' => false, 'message' => 'Parceiro inexistente.'];

        if ($partner_id == 7) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_URL, 'https://sgsol.ucsal.br/brjuridico/ucsal.php');
            curl_setopt($ch, CURLOPT_REFERER, 'https://sgsol.ucsal.br/brjuridico/ucsal.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "cpf=" . $key . "&senha=0175c7024bfac4fd8fc6ba852be7cdb3");
            $ret = curl_exec($ch);
            curl_close($ch);
        } else {
            return ['available' => false, 'message' => 'Parceiro inexistente.'];
        }

        // Check if coupon is restrict to users
        if ($ret != '1')
            return ['available' => false, 'message' => 'CPF não está vinculado a um aluno ou ex-aluno da Universidade Católica da Bahia.'];

        $partner->key = $key;

        $this->setPartnerInSession($partner);
        $this->calculateDiscountFromPartner($partner);

        return ['available' => true, 'message' => 'Desconto de parceiro aplicado.'];
    }

    /**
     * Calculate discount from a validated coupon
     *
     * @param $coupon
     */
    public function calculateDiscountFromPartner($partner) {
        $cart = $this->getFullCart();

        if (($partner->key != null) && ($partner->key != '')) {
            $discount = ($partner->percentage_discount / 100) * $cart->total;
        }

        if (isset($discount))
            $this->setDiscountInSession($discount);
    }

    /**
     * Apply discounts in order course items
     *
     * @param $coupon_code
     */
    public function applyPartnerDiscountsCourseItems($partner_id) {

        $order = $this->order->updateTotalById($this->orderInSession, $this->get('total'));
        $partner = $this->getPartnerInSession();
        $i = 0;
        $a = array(); //

        foreach ($order->courses as $OrderCourse) {

            ///Caso o preço original sejo o mesmo preço de venda no site
            if ($OrderCourse->original_price == $OrderCourse->price) {
                $discount = ($partner->percentage_discount / 100) * $OrderCourse->price;
                $OrderCourse->discount_price = $OrderCourse->price - $discount;
            } else { //Caso o preço do site seja diferente do preço original do produto
                $checkDiscount = ($partner->percentage_discount / 100) * $OrderCourse->original_price;

                if ($checkDiscount > $OrderCourse->price) { //Caso o desconto seja maior que o valor do produto no site
                    $discount = $OrderCourse->price; //O valor do desconto será o valor do produto, ou seja, 100%
                    $OrderCourse->discount_price = $OrderCourse->price - $discount;
                } else {

                    $discount = ($partner->percentage_discount / 100) * $OrderCourse->original_price;
                    $perc_valid = (($OrderCourse->original_price - $discount) / $OrderCourse->price); //Percentual Válido para desconto

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

                    $discount = $perc_valid * $OrderCourse->price;
                    $OrderCourse->discount_price = $OrderCourse->price - $discount;
                }
            }
            $a[$i] = $discount;
            $OrderCourse->save();

            $this->updateById($OrderCourse->course_id, 'course', ['discount_price' => $OrderCourse->discount_price]);

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
    public function applyPartnerDiscountsPackageItems($partner_id) {
        $order = $this->order->updateTotalById($this->orderInSession, $this->get('total'));
        $totalDiscount = $this->getDiscountInSession();
        $partner = $this->getPartnerInSession();
        $i = 0;
        $a = array();
        foreach ($order->packages as $orderPackage) {

            ///Caso o preço original sejo o mesmo preço de venda no site
            if ($orderPackage->original_price == $orderPackage->price) {
                $discount = ($partner->percentage_discount / 100) * $orderPackage->price;
                $orderPackage->discount_price = $orderPackage->price - $discount;
            } else { //Caso o preço do site seja diferente do preço original do produto
                $checkDiscount = ($partner->percentage_discount / 100) * $orderPackage->original_price;

                if ($checkDiscount > $orderPackage->price) { //Caso o desconto seja maior que o valor do produto no site
                    $discount = $orderPackage->price; //O valor do desconto será o valor do produto, ou seja, 100%
                } else {
                    $discount = ($partner->percentage_discount / 100) * $orderPackage->original_price;

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

                
                
                $orderPackage->discount_price = $orderPackage->price - $discount;
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
//        session(['discount' => $totalDiscount]);

        return $totalDiscount;
    }

}
