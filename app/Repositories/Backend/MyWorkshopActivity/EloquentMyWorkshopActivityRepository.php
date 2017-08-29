<?php namespace App\Repositories\Backend\MyWorkshopActivity;

use App\MyWorkshopActivity;
use App\Exceptions\GeneralException;

/**
 * Class EloquentMyWorkshopActivityRepository
 * @package App\Repositories\MyWorkshopActivity
 */
class EloquentMyWorkshopActivityRepository implements MyWorkshopActivityContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $myworkshopactivity = MyWorkshopActivity::withTrashed()->find($id);

        if (! is_null($myworkshopactivity)) return $myworkshopactivity;

        throw new GeneralException('That myworkshopactivity does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getMyWorkshopActivitysPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '') {
        return MyWorkshopActivity::where('workshop_id', '=', $f_workshop_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedMyWorkshopActivitysPaginated($per_page) {
        return MyWorkshopActivity::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllMyWorkshopActivitys($order_by = 'id', $sort = 'asc') {
        return MyWorkshopActivity::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $myworkshopactivity = $this->createMyWorkshopActivityStub($input);
        if($myworkshopactivity->save())
            return $myworkshopactivity;
        throw new GeneralException('There was a problem creating this myworkshopactivity. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $myworkshopactivity = $this->findOrThrowException($id);


        if ($myworkshopactivity->update($input)) {
            $myworkshopactivity->save();

            return $myworkshopactivity;
        }

        throw new GeneralException('There was a problem updating this myworkshopactivity. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $myworkshopactivity = $this->findOrThrowException($id);
        if ($myworkshopactivity->delete())
            return true;

        throw new GeneralException("There was a problem deleting this myworkshopactivity. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createMyWorkshopActivityStub($input)
    {

        $myworkshopactivity = new MyWorkshopActivity;
        $myworkshopactivity->name = $input['name'];
        $myworkshopactivity->description = $input['description'];
        return $myworkshopactivity;
    }

}