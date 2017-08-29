<?php

namespace App\Services\Cart;

use App\Exceptions\GeneralException;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Backend\OrderCourse\OrderCourseContract;
use App\Repositories\Backend\OrderPackage\OrderPackageContract;
use App\Repositories\Frontend\Coupon\CouponContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Package\PackageContract;
use App\Repositories\Backend\Partner\PartnerContract;
use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * Created by PhpStorm.
 * User: soufraz
 * Date: 1/12/16
 * Time: 11:16 AM
 */
class CartService {

    use CartSession,
        CartPersistenceDB,
        CartPayment,
        CartCoupon,
        CartPackageDiscount,
        CartCourseFromExamDiscount,
        CartPartner;

    /**
     * @param OrderContract $order
     * @param OrderCourseContract $orderCourse
     * @param OrderPackageContract $orderPackage
     * @param CourseContract $courses
     * @param PackageContract $packages
     * @param CouponContract $coupon
     */
    public function __construct(OrderContract $order, OrderCourseContract $orderCourse, OrderPackageContract $orderPackage, CourseContract $courses, PackageContract $packages, CouponContract $coupon, PartnerContract $partner) {
        $this->order = $order;
        $this->orderCourse = $orderCourse;
        $this->orderPackage = $orderPackage;

        $this->courses = $courses;
        $this->packages = $packages;

        $this->coupon = $coupon;

        $this->partner = $partner;

        $this->orderInSession = $this->getOrderIdInSession();
    }

    /**
     * Helper to get info from Cart
     *
     * @param $s
     * @return mixed
     */
    public function get($s) {
        $cart = [
            'content' => Cart::content(),
            'total' => Cart::total(),
        ];

        return $cart[$s];
    }

    /**
     * Get cart and add discount and total
     *
     * @return mixed
     */
    public function getFullCart() {
        $items = $this->get('content');
        $items->discount = session('discount');
        $items->total = $this->get('total') - session('discount');

        return $items;
    }

    /**
     * Get cart item by id
     *
     * @param $item_id
     * @param $type
     * @return mixed
     */
    public function getById($item_id, $type) {
        return Cart::search(['id' => (int) $item_id, 'options' => ['type' => $type]]);
    }

    /**
     * Add item to cart
     *
     * @param $item
     * @param $type
     */
    public function addItem($item, $type) {
        $this->handleWithLastCart();
        Cart::add([
            'id' => (int) $item->id,
            'name' => $item->title,
            'qty' => 1,
            'price' => $item->final_price,            
            'options' => ['type' => $type, 'discount_price' => $item->final_price, 'original_price' => $item->price, 'featured_img' => $item->featured_img,
                'course_from_exam' => $item->course_from_exam, 'max_installments' => $item->max_installments]
        ]);

        $this->createOrUpdateOrder($item, $type);
    }

    /**
     * Get item by type
     *
     * @param $item_id
     * @param $type
     * @return mixed
     * @throws GeneralException
     */
    public function getItemByType($item_id, $type) {
        switch ($type) {
            case 'course':
                $item = $this->courses->findOrThrowException($item_id);
                if ($item->is_active == '0') {
                    throw new GeneralException('Curso indisponível');
                }
                break;
            case 'package':
                $item = $this->packages->findOrThrowException($item_id);
                //Se estiver ativo
                if ($item->is_active == '0') {
                    throw new GeneralException('SAAP indisponível');
                }
                break;
            default:
                throw new GeneralException('Erro no tipo de item que está sendo comprado. Item de id:' . ($item_id != null ? $item_id : "Desconhecido"));
                break;
        }
        return $item;
    }

    /**
     * Update a cart item by id
     *
     * @param $item_id
     * @param $type
     * @param array $to_update
     * @return mixed
     */
    public function updateById($item_id, $type, array $to_update) {
        $rowid = Cart::search(['id' => (int) $item_id, 'options' => ['type' => $type]]);
        Cart::update($rowid[0], ['options' => $to_update]);
    }

    /**
     * Remove item from cart
     * @param $id
     */
    public function removeItem($id) {
        $this->destroyDiscount();
        $item = Cart::get($id);
        Cart::remove($id);
        $this->deleteOrderItem($item);
    }

    /**
     * Destroy cart
     */
    public function destroy() {
        Cart::destroy();
    }

}
