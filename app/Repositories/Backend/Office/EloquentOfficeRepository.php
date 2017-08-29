<?php namespace App\Repositories\Backend\Office;

use App\Office;
use App\Exceptions\GeneralException;

/**
 * Class EloquentOfficeRepository
 * @package App\Repositories\Office
 */
class EloquentOfficeRepository implements OfficeContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $office = Office::withTrashed()->find($id);

        if (! is_null($office)) return $office;

        throw new GeneralException('That office does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getOfficesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_OfficeController_name = '') {
        return Office::where('name', 'like', '%'.$f_OfficeController_name.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedOfficesPaginated($per_page) {
        return Office::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllOffices($order_by = 'id', $sort = 'asc') {
        return Office::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $office = $this->createOfficeStub($input);
        if($office->save())
            return $office;
        throw new GeneralException('There was a problem creating this office. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $office = $this->findOrThrowException($id);


        if ($office->update($input)) {
            $office->save();

            return $office;
        }

        throw new GeneralException('There was a problem updating this office. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $office = $this->findOrThrowException($id);
        if ($office->delete())
            return true;

        throw new GeneralException("There was a problem deleting this office. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createOfficeStub($input)
    {

        $office = new Office;
        $office->name = $input['name'];
        $office->description = $input['description'];
        return $office;
    }

}