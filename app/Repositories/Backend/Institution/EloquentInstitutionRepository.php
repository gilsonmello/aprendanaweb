<?php namespace App\Repositories\Backend\Institution;

use App\Institution;
use App\Exceptions\GeneralException;

/**
 * Class EloquentInstitutionRepository
 * @package App\Repositories\Institution
 */
class EloquentInstitutionRepository implements InstitutionContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$institution = Institution::withTrashed()->find($id);

		if (! is_null($institution)) return $institution;

		throw new GeneralException('That institution does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getInstitutionsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_InstitutionController_name = '') {
		return Institution::where('name', 'like', '%'.$f_InstitutionController_name.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedInstitutionsPaginated($per_page) {
		return Institution::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllInstitutions($order_by = 'id', $sort = 'asc') {
		return Institution::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $institution = $this->createInstitutionStub($input);
        if($institution->save())
            return $institution;
        throw new GeneralException('There was a problem creating this institution. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $institution = $this->findOrThrowException($id);


        if ($institution->update($input)) {
            $institution->save();

            return $institution;
        }

        throw new GeneralException('There was a problem updating this institution. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $institution = $this->findOrThrowException($id);
        if ($institution->delete())
            return true;

        throw new GeneralException("There was a problem deleting this institution. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createInstitutionStub($input)
    {

        $institution = new Institution;
        $institution->name = $input['name'];
        $institution->description = $input['description'];
        $institution->abbreviation = $input['abbreviation'];
        return $institution;
    }

}