<?php namespace App\Repositories\Backend\Partnerorder;

use App\Partnerorder;
use App\Exceptions\GeneralException;

/**
 * Class EloquentPartnerorderRepository
 * @package App\Repositories\Partnerorder
 */
class EloquentPartnerorderRepository implements PartnerorderContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$partnerorder = Partnerorder::withTrashed()->find($id);

		if (! is_null($partnerorder)) return $partnerorder;

		throw new GeneralException('That partnerorder does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getPartnerordersPaginated($per_page, $partner_id, $order_by = 'id', $sort = 'asc', $f_PartnerorderController_name = '') {
        $query = Partnerorder::whereNotNull('id');
        if (isset($partner_id) && $partner_id != "" && $partner_id != "0")
            $query->where('partner_id', '=', $partner_id);

        return $query->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedPartnerordersPaginated($per_page) {
		return Partnerorder::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllPartnerorders($order_by = 'id', $sort = 'asc') {
		return Partnerorder::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $partnerorder = $this->createPartnerorderStub($input);
        $partnerorder->course()->associate($input['course_id']);        unset($input['course_id']);
        $partnerorder->partner()->associate($input['partner_id']);        unset($input['partner_id']);
        if($partnerorder->save())
            return $partnerorder;
        throw new GeneralException('There was a problem creating this partnerorder. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $partnerorder = $this->findOrThrowException($id);

        $partnerorder->external_course_id = $input['external_course_id'];
        $partnerorder->html_email = $input['html_email'];
        $partnerorder->html_subscribe = $input['html_subscribe'];
        $partnerorder->is_active = isset($input['is_active']) ? 1 : 0;
        $partnerorder->value = parsemoneybr($input['value']);

        $partnerorder->save();

        return $partnerorder;

        throw new GeneralException('There was a problem updating this partnerorder. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $partnerorder = $this->findOrThrowException($id);
        if ($partnerorder->delete())
            return true;

        throw new GeneralException("There was a problem deleting this partnerorder. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createPartnerorderStub($input)
    {

        $partnerorder = new Partnerorder;
        $partnerorder->date = parsebr($input['date']);
        $partnerorder->total_enrollments = $input['total_enrollments'];
        $partnerorder->used_enrollments = 0;
        $partnerorder->external_course_id = $input['external_course_id'];
        $partnerorder->html_email = $input['html_email'];
        $partnerorder->html_subscribe = $input['html_subscribe'];
        $partnerorder->is_active = isset($input['is_active']) ? 1 : 0;
        $partnerorder->value = parsemoneybr($input['value']);
        return $partnerorder;
    }

}