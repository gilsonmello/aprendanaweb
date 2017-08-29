<?php namespace App\Repositories\Backend\OrderLesson;

use App\OrderLesson;
use App\Exceptions\GeneralException;

/**
 * Class EloquentOrderLessonRepository
 * @package App\Repositories\OrderLesson
 */
class EloquentOrderLessonRepository implements OrderLessonContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$orderLesson = OrderLesson::withTrashed()->find($id);

		if (! is_null($orderLesson)) return $orderLesson;

		throw new GeneralException('That orderLesson does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getOrderLessonsPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return OrderLesson::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedOrderLessonsPaginated($per_page) {
		return OrderLesson::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllOrderLessons($order, $order_by = 'id', $sort = 'asc') {
		return OrderLesson::where('order_id', '=', $order)->orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $orderLesson = $this->createOrderLessonStub($input);
        if($orderLesson->save())
            return true;
        throw new GeneralException('There was a problem creating this orderLesson. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $orderLesson = $this->findOrThrowException($id);


        if ($orderLesson->update($input)) {
            $orderLesson->name  = $input['name'];
            $orderLesson->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this orderLesson. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $orderLesson = $this->findOrThrowException($id);
        if ($orderLesson->delete())
            return true;

        throw new GeneralException("There was a problem deleting this orderLesson. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createOrderLessonStub($input)
    {

        $orderLesson = new OrderLesson;
        $orderLesson->name = $input['name'];
        return $orderLesson;
    }

}