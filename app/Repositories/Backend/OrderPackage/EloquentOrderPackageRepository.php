<?php

namespace App\Repositories\Backend\OrderPackage;

use App\OrderPackage;
use App\Exceptions\GeneralException;

/**
 * Class EloquentOrderPackageRepository
 * @package App\Repositories\OrderPackage
 */
class EloquentOrderPackageRepository implements OrderPackageContract {
//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $orderPackage = OrderPackage::withTrashed()->find($id);

        if (!is_null($orderPackage))
            return $orderPackage;

        throw new GeneralException('That orderPackage does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getOrderPackagesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return OrderPackage::orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedOrderPackagesPaginated($per_page) {
        return OrderPackage::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllOrderPackages($order, $order_by = 'id', $sort = 'asc') {
        return OrderPackage::where('order_id', '=', $order)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $order_id
     * @param $package_id
     * @return mixed
     */
    public function getByOrderAndPackage($order_id, $package_id) {
        return OrderPackage::where('order_id', '=', $order_id)->where('package_id', '=', $package_id)->first();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $orderPackage = $this->createOrderPackageStub($input);
        if ($orderPackage->save())
            return true;
        throw new GeneralException('There was a problem creating this orderPackage. Please try again.');
    }

    public function createByCartAdd($order, $package) {
        $orderPackage = new OrderPackage;
        $orderPackage->order_id = $order->id;
        $orderPackage->package_id = $package->id;
        $orderPackage->price = $package->final_price;
        $orderPackage->original_price = $package->price;
        $orderPackage->discount_price = $package->final_price;
        if ($orderPackage->save())
            return true;

        throw new GeneralException('There was a problem creating this orderPackage. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $orderPackage = $this->findOrThrowException($id);


        if ($orderPackage->update($input)) {
            $orderPackage->name = $input['name'];
            $orderPackage->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this orderPackage. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $orderPackage = $this->findOrThrowException($id);
        if ($orderPackage->delete())
            return true;

        throw new GeneralException("There was a problem deleting this orderPackage. Please try again.");
    }

    /**
     * @param $order_id
     * @return bool
     * @throws GeneralException
     */
    public function destroyByOrder($order_id) {
        if (OrderPackage::where('order_id', $order_id)->delete())
            return true;

        throw new GeneralException("There was a problem deleting this orderPackage. Please try again.");
    }

    /**
     * @param $order_id
     * @param $package_id
     * @return bool
     * @throws GeneralException
     */
    public function destroyByOrderAndPackage($order_id, $package_id) {
        $affectedRows = OrderPackage::where('order_id', $order_id)->where('package_id', $package_id)->delete();
        if ($affectedRows == 0)
            throw new GeneralException("There was a problem deleting this orderPackage. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createOrderPackageStub($input) {

        $orderPackage = new OrderPackage;
        $orderPackage->name = $input['name'];
        return $orderPackage;
    }

}
