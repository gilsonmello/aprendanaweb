<?php namespace App\Repositories\Backend\Occupation;

use App\Occupation;
use App\Exceptions\GeneralException;

/**
 * Class EloquentOccupationRepository
 * @package App\Repositories\Occupation
 */
class EloquentOccupationRepository implements OccupationContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $occupation = Occupation::withTrashed()->find($id);

        if (! is_null($occupation)) return $occupation;

        throw new GeneralException('That occupation does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getOccupationsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_OccupationController_description = '') {
        return Occupation::where('description', 'like', '%'.$f_OccupationController_description.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedOccupationsPaginated($per_page) {
        return Occupation::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllOccupations($order_by = 'id', $sort = 'asc') {
        return Occupation::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $occupation = $this->createOccupationStub($input);
        if($occupation->save())
            return $occupation;
        throw new GeneralException('There was a problem creating this occupation. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $occupation = $this->findOrThrowException($id);


        if ($occupation->update($input)) {
            $occupation->save();

            return $occupation;
        }

        throw new GeneralException('There was a problem updating this occupation. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $occupation = $this->findOrThrowException($id);
        if ($occupation->delete())
            return true;

        throw new GeneralException("There was a problem deleting this occupation. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createOccupationStub($input)
    {

        $occupation = new Occupation;
        $occupation->description = $input['description'];
        return $occupation;
    }

}