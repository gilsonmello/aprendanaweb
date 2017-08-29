<?php namespace App\Repositories\Backend\Partner;

use App\Partner;
use App\Exceptions\GeneralException;

/**
 * Class EloquentPartnerRepository
 * @package App\Repositories\Partner
 */
class EloquentPartnerRepository implements PartnerContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$partner = Partner::withTrashed()->find($id);

		if (! is_null($partner)) return $partner;

		throw new GeneralException('Parceiro inexistente.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getPartnersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_PartnerController_name = '') {
		return Partner::where('name', 'like', '%'.$f_PartnerController_name.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedPartnersPaginated($per_page) {
		return Partner::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllPartners($order_by = 'id', $sort = 'asc') {
		return Partner::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $partner = $this->createPartnerStub($input);
        if($partner->save())
            return $partner;
        throw new GeneralException('There was a problem creating this partner. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $partner = $this->findOrThrowException($id);


        if ($partner->update($input)) {
            if(isset($input['logo'])) $partner->logo = $input['logo'];
            $partner->video_quality = (isset($input['video_quality']) ? $input['video_quality'] : '0');
            $partner->save();

            return $partner;
        }

        throw new GeneralException('There was a problem updating this partner. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $partner = $this->findOrThrowException($id);
        if ($partner->delete())
            return true;

        throw new GeneralException("There was a problem deleting this partner. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createPartnerStub($input)
    {

        $partner = new Partner;
        $partner->name = $input['name'];
        $partner->contact = $input['contact'];
        $partner->phone = $input['phone'];
        $partner->days_subscribe = $input['days_subscribe'];
        $partner->video_quality = (isset($input['video_quality']) ? $input['video_quality'] : '0');
        if(isset($input['logo'])) $partner->logo = $input['logo'];
        return $partner;
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateLogo($id, $new_file_name) {
        $partner = $this->findOrThrowException($id);
        $partner->logo  = $new_file_name;
        if($partner->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

}