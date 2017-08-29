<?php namespace App\Services\Cart;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 12/05/16
 * Time: 15:32
 */
  
trait CartPackageDiscount {

    private $progressiveDiscount = [
        2 => 10,
        3 => 15,
        4 => 20,
        5 => 25,
        6 => 30
    ];

    /**
     * Calculate discount from a validated coupon
     */
    public function calculateDiscountFromPackages()
    {
        $cart = $this->getFullCart();

        $packagesInCart = [];
        foreach($cart as $item){
            if($item->options->type == 'package'){
                $packagesInCart[] = ['id' => $item->id, 'price' => $item->price];
            }
        }

        if(count($packagesInCart) < 2) return;

        if(count($packagesInCart) > 6){
            $discountPerPackages = 30;
        }else{
            $discountPerPackages = $this->progressiveDiscount[count($packagesInCart)];
        }

        $discount = $this->getDiscountInSession();
        for($i=0; $i < count($packagesInCart); $i++){
            $itemDiscount = ($discountPerPackages / 100) * $packagesInCart[$i]['price'];
            $discount = $discount + $itemDiscount;
            $packagesInCart[$i]['discount'] = $itemDiscount;
        }

        if(isset($discount)) $this->setDiscountInSession($discount);

        $this->applyProgressiveDiscountsPackageItems($packagesInCart);
    }

    /**
     * Apply discounts in order package items
     * @param $packagesInCart
     */
    public function applyProgressiveDiscountsPackageItems($packagesInCart)
    {
        $this->order->updateTotalById($this->orderInSession, $this->get('total'));

        foreach ($packagesInCart as $item) {
            $discount = $item['discount'];

            $orderPackage = $this->orderPackage->getByOrderAndPackage($this->orderInSession, $item['id']);
            $orderPackage->discount_price = $orderPackage->price - $discount;
            $orderPackage->save();

            $this->updateById($orderPackage->package_id, 'package', ['discount_price' => $orderPackage->discount_price]);
        }
    }

}