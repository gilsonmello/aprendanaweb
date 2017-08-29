<?php namespace App\Repositories\Backend\City;

use App\City;
use App\Exceptions\GeneralException;

/**
 * Class EloquentCityRepository
 * @package App\Repositories\City
 */
class EloquentCityRepository implements CityContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$city = City::withTrashed()->find($id);

		if (! is_null($city)) return $city;

		throw new GeneralException('That cities does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getCitiesPaginated($per_page, $f_CityController_name, $order_by = 'name', $sort = 'asc') {
		return City::where('name', 'like', '%'.$f_CityController_name.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedCitiesPaginated($per_page) {
		return City::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllCities($order_by = 'id', $sort = 'asc') {
		return City::orderBy($order_by, $sort)->get();
	}

    public function selectCities($term = '', $order_by = 'name', $sort = 'asc') {
        return City::where('name', 'like', $term.'%')->orderBy($order_by, $sort)->get();
    }
    
    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $city = $this->createCityStub($input);
        if($city->save())
            return true;
        throw new GeneralException('There was a problem creating this cities. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $city = $this->findOrThrowException($id);

        if ($city->update($input)) {
            $city->name = $input['name'];
            $city->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this cities. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $city = $this->findOrThrowException($id);
        if ($city->delete())
            return true;

        throw new GeneralException("There was a problem deleting this cities. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createCityStub($input)
    {
        $city = new City;
		$city->name  = $input['name'];
		$city->state_id = 1;
        return $city;
    }

}