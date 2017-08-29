<?php namespace App\Repositories\Backend\OrderModule;

use App\OrderModule;
use App\Exceptions\GeneralException;

/**
 * Class EloquentOrderModuleRepository
 * @package App\Repositories\OrderModule
 */
class EloquentOrderModuleRepository implements OrderModuleContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$orderModule = OrderModule::withTrashed()->find($id);

		if (! is_null($orderModule)) return $orderModule;

		throw new GeneralException('That orderModule does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getOrderModulesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return OrderModule::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedOrderModulesPaginated($per_page) {
		return OrderModule::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllOrderModules($order, $order_by = 'id', $sort = 'asc') {
		return OrderModule::where('order_id', '=', $order)->orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $orderModule = $this->createOrderModuleStub($input);
        if($orderModule->save())
            return true;
        throw new GeneralException('There was a problem creating this orderModule. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $orderModule = $this->findOrThrowException($id);


        if ($orderModule->update($input)) {
            $orderModule->name  = $input['name'];
            $orderModule->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this orderModule. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $orderModule = $this->findOrThrowException($id);
        if ($orderModule->delete())
            return true;

        throw new GeneralException("There was a problem deleting this orderModule. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createOrderModuleStub($input)
    {

        $orderModule = new OrderModule;
        $orderModule->name = $input['name'];
        return $orderModule;
    }

}