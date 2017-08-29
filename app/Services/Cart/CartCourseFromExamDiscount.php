<?php namespace App\Services\Cart;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 12/05/16
 * Time: 15:32
 */
  
trait CartCourseFromExamDiscount {

    private $progressiveDiscountCourseFromExam = [
        1 => 10,
        2 => 15,
        3 => 20,
        4 => 25,
        5 => 30
    ];

    /**
     * Calculate discount from a validated coupon
     */
    public function calculateDiscountFromCourses()
    {
        $cart = $this->getFullCart();

        $coursesInCart = [];
        foreach($cart as $item){
            if(($item->options->type == 'course') && ($item->options->course_from_exam != null) && ($item->options->course_from_exam == 1)){
                $coursesInCart[] = ['id' => $item->id, 'price' => $item->price];
            }
        }

        if(count($coursesInCart) < 1) return;

        if(count($coursesInCart) > 5){
            $discountPerCourse = 30;
        }else{
            $discountPerCourse = $this->progressiveDiscountCourseFromExam[count($coursesInCart)];
        }


        $discount = $this->getDiscountInSession();
        for($i=0; $i < count($coursesInCart); $i++){
            $itemDiscount = ($discountPerCourse / 100) * $coursesInCart[$i]['price'];
            $discount = $discount + $itemDiscount;
            $coursesInCart[$i]['discount'] = $itemDiscount;
        }

        if(isset($discount)) $this->setDiscountInSession($discount);

        $this->applyProgressiveDiscountsCourseItems($coursesInCart);
    }

    /**
     * Apply discounts in order package items
     * @param $packagesInCart
     */
    public function applyProgressiveDiscountsCourseItems($coursesInCart)
    {
        $this->order->updateTotalById($this->orderInSession, $this->get('total'));

        foreach ($coursesInCart as $item) {
            $discount = $item['discount'];

            $orderCourse = $this->orderCourse->getByOrderAndCourse($this->orderInSession, $item['id']);
            $orderCourse->discount_price = $orderCourse->price - $discount;
            $orderCourse->save();

            $this->updateById($orderCourse->course_id, 'course', ['discount_price' => $orderCourse->discount_price]);
        }
    }

}