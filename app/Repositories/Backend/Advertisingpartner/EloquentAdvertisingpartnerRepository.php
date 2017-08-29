<?php namespace App\Repositories\Backend\Advertisingpartner;

use App\Advertisingpartner;
use App\Exceptions\GeneralException;

/**
 * Class EloquentAdvertisingpartnerRepository
 * @package App\Repositories\Advertisingpartner
 */
class EloquentAdvertisingpartnerRepository implements AdvertisingpartnerContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$advertisingpartner = Advertisingpartner::withTrashed()->find($id);

		if (! is_null($advertisingpartner)) return $advertisingpartner;

		throw new GeneralException('That advertisingpartner does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAdvertisingpartnersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AdvertisingpartnerController_name = '') {
		return Advertisingpartner::where('name', 'like', '%'.$f_AdvertisingpartnerController_name.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedAdvertisingpartnersPaginated($per_page) {
		return Advertisingpartner::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllAdvertisingpartners($order_by = 'id', $sort = 'asc') {
		return Advertisingpartner::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $advertisingpartner = $this->createAdvertisingpartnerStub($input);
        if($advertisingpartner->save())
            return $advertisingpartner;
        throw new GeneralException('There was a problem creating this advertisingpartner. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $advertisingpartner = $this->findOrThrowException($id);


        if ($advertisingpartner->update($input)) {
            $advertisingpartner->save();

            return $advertisingpartner;
        }

        throw new GeneralException('There was a problem updating this advertisingpartner. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $advertisingpartner = $this->findOrThrowException($id);
        if ($advertisingpartner->delete())
            return true;

        throw new GeneralException("There was a problem deleting this advertisingpartner. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAdvertisingpartnerStub($input)
    {

        $advertisingpartner = new Advertisingpartner;
        $advertisingpartner->name = $input['name'];
        $advertisingpartner->contact = $input['contact'];
        $advertisingpartner->phone = $input['phone'];
        $advertisingpartner->source = $input['source'];
        return $advertisingpartner;
    }

}