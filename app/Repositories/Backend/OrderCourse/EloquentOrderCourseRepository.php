<?php

namespace App\Repositories\Backend\OrderCourse;

use App\OrderCourse;
use App\Exceptions\GeneralException;

/**
 * Class EloquentOrderCourseRepository
 * @package App\Repositories\OrderCourse
 */
class EloquentOrderCourseRepository implements OrderCourseContract {
//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $orderCourse = OrderCourse::withTrashed()->find($id);

        if (!is_null($orderCourse))
            return $orderCourse;

        throw new GeneralException('That orderCourse does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getOrderCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return OrderCourse::orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedOrderCoursesPaginated($per_page) {
        return OrderCourse::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllOrderCourses($order, $order_by = 'id', $sort = 'asc') {
        return OrderCourse::where('order_id', '=', $order)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $order_id
     * @param $package_id
     * @return mixed
     */
    public function getByOrderAndCourse($order_id, $course_id) {
        return OrderCourse::where('order_id', '=', $order_id)->where('course_id', '=', $course_id)->first();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $orderCourse = $this->createOrderCourseStub($input);
        if ($orderCourse->save())
            return true;
        throw new GeneralException('There was a problem creating this orderCourse. Please try again.');
    }

    public function createByCartAdd($order, $course) {
        
        $orderCourse = new OrderCourse;
        $orderCourse->order_id = $order->id;
        $orderCourse->course_id = $course->id;
        $orderCourse->original_price = $course->price;
        $orderCourse->price = $course->final_price;
        $orderCourse->discount_price = $course->final_price;
        if ($orderCourse->save())
            return true;

        throw new GeneralException('There was a problem creating this orderCourse. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $orderCourse = $this->findOrThrowException($id);


        if ($orderCourse->update($input)) {
            $orderCourse->name = $input['name'];
            $orderCourse->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this orderCourse. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $orderCourse = $this->findOrThrowException($id);
        if ($orderCourse->delete())
            return true;

        throw new GeneralException("There was a problem deleting this orderCourse. Please try again.");
    }

    /**
     * @param $order_id
     * @return bool
     * @throws GeneralException
     */
    public function destroyByOrder($order_id) {
        if (OrderCourse::where('order_id', $order_id)->delete())
            return true;

        throw new GeneralException("There was a problem deleting this orderCourse. Please try again.");
    }

    /**
     * @param $order_id
     * @param $course_id
     * @return bool
     * @throws GeneralException
     */
    public function destroyByOrderAndCourse($order_id, $course_id) {
        $affectedRows = OrderCourse::where('order_id', $order_id)->where('course_id', $course_id)->delete();
        if ($affectedRows == 0)
            throw new GeneralException("There was a problem deleting this orderCourse. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createOrderCourseStub($input) {

        $orderCourse = new OrderCourse;
        $orderCourse->name = $input['name'];
        return $orderCourse;
    }

}
